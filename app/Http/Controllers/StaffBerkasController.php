<?php

namespace App\Http\Controllers;

use App\Models\BerkasKknModel;
use App\Models\KknMahasiswaModel;
use App\Models\KknModel;
use App\Models\LuaranModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\SkemaModel;
use Dotenv\Util\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StaffBerkasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $skema = SkemaModel::all();
    $search = $request->input('searchkKn');
    $selectedSkema = $request->input('skema');

    $kknQuery = KknModel::with(['skema']);

    // Pencarian berdasarkan nama, desa, kecamatan, kabupaten, atau periode
    if ($search) {
        $kknQuery->where(function ($query) use ($search) {
            $query->where('nama', 'LIKE', '%' . $search . '%')
                ->orWhereHas('desa', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('desa.kecamatan', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('desa.kecamatan.kabupaten', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('periode', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', '%' . $search . '%');
                });
        });
    }

    // Penapisan berdasarkan skema
    if ($selectedSkema) {
        $kknQuery->whereHas('skema', function ($subquery) use ($selectedSkema) {
            $subquery->where('nama', $selectedSkema);
        });
    }

    // Ambil data dengan paginasi
    $kkn = $kknQuery->paginate(10);

        return view('pages.staff.berkas.index', compact('skema', 'kkn', 'search', 'selectedSkema'));
    }


    public function mahasiswa(Request $request, string $nama, string $periode)
{
    try {
        $search = $request->input('searchkKn');
        $selectedProdi = $request->input('prodi');

        $kkn = KknModel::where('nama', $nama)
        ->whereHas('periode', function ($query) use ($periode) {
            $query->where('nama', $periode);
        })
        ->firstOrFail();

    $prodi = $kkn->kknMahasiswas->map(function ($kknMahasiswa) {
        return $kknMahasiswa->mahasiswa->prodi;
    });

    $mahasiswaKkn = $this->getFilteredMahasiswaList($kkn, $search, $selectedProdi);

    $mahasiswaList = $kkn->kknMahasiswas->pluck('mahasiswa');
    $mahasiswaList = $mahasiswaList->filter(function ($mahasiswa) use ($mahasiswaKkn) {
        return $mahasiswaKkn->contains('mahasiswa_id', $mahasiswa->mahasiswa_id);
    });

    $mahasiswaIds = $mahasiswaList->pluck('mahasiswa_id')->toArray();
    $mahasiswaList = MahasiswaModel::whereIn('mahasiswa_id', $mahasiswaIds)->paginate(10);

    // dd($mahasiswaList->toArray());

        return view('pages.staff.berkas.list-mahasiswa', compact('kkn', 'mahasiswaList', 'prodi', 'search', 'selectedProdi'));
    } catch (ModelNotFoundException $e) {
        return redirect()->route('staff.list.berkas.kkn')->with('error_message_not_found', 'Data kkn tidak ditemukan');
    }
}

private function getFilteredMahasiswaList(KknModel $kkn, $search, $selectedProdi)
{
    $mahasiswaQuery = MahasiswaModel::where(function ($query) use ($search) {
        $query->where('nama', 'LIKE', '%' . $search . '%')
            ->orWhere('nim', 'LIKE', '%' . $search . '%')
            ->orWhere('jenis_kelamin', 'LIKE', '%' . $search . '%')
            ->orWhere('telp', 'LIKE', '%' . $search . '%')
            ->orWhere('alamat', 'LIKE', '%' . $search . '%')
            ->orWhereHas('prodi', function ($query) use ($search) {
                $query->where('nama', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('prodi.fakultas', function ($query) use ($search) {
                $query->where('nama', 'LIKE', '%' . $search . '%');
            });
    });

    // Jika ada prodi dipilih, tambahkan filter prodi
    if ($selectedProdi) {
        $mahasiswaQuery->whereHas('prodi', function ($subquery) use ($selectedProdi) {
            $subquery->where('nama', $selectedProdi);
        });
    }

    // Assuming that kknMahasiswas relationship is loaded efficiently
    $perPage = 10; // Jumlah item per halaman
    $mahasiswaList = $mahasiswaQuery->paginate($perPage);

    // Mengambil query string dari URL dan menambahkannya ke hasil pagination
    $mahasiswaList->appends(request()->query());

    return $mahasiswaList;
}

    public function berkas(string $nama, string $periode, string $nim)
    {
        try {
            $kkn = KknModel::where('nama', $nama)
            ->whereHas('periode', function ($query) use ($periode) {
                $query->where('nama', $periode);
            })
            ->firstOrFail();

        $mahasiswa = $kkn->kknMahasiswas->filter(function ($kknMahasiswa) use ($nim) {
            return $kknMahasiswa->mahasiswa->nim === $nim;
        });

        $kknMahasiswaIds = $mahasiswa->pluck('kkn_mhs_id')->toArray();

        $luaranIds = LuaranModel::whereIn('kkn_mhs_id', $kknMahasiswaIds)->pluck('luaran_id')->toArray();

        $berkas = BerkasKknModel::whereIn('luaran_id', $luaranIds)->get();
            // dd($berkas);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('staff.list.berkas.kkn')->with('error_message_not_found', 'Data kkn tidak ditemukan');
        }
        return view('pages.staff.berkas.berkas', compact('kkn', 'berkas'));
    }

    public function editStatusBerkas(Request $request, string $nama, string $periode, string $nim, string $berkasId)
{
    try {
        $status = $request->input('status');
        $kkn = KknModel::where('nama', $nama)
            ->whereHas('periode', function ($query) use ($periode) {
                $query->where('nama', $periode);
            })
            ->firstOrFail();

        $mahasiswa = $kkn->kknMahasiswas->filter(function ($kknMahasiswa) use ($nim) {
            return $kknMahasiswa->mahasiswa->nim === $nim;
        });

        $kknMahasiswaIds = $mahasiswa->pluck('kkn_mhs_id')->toArray();

        $luaranIds = LuaranModel::whereIn('kkn_mhs_id', $kknMahasiswaIds)->pluck('luaran_id')->toArray();

        $berkas = BerkasKknModel::whereIn('luaran_id', $luaranIds)->get();
        BerkasKknModel::where('berkas_id', $berkasId)->update(['status' => $status]);

        Session::flash('success_message_create', 'Data berkas berhasil diperbarui');
        return redirect()->back();
    } catch (ModelNotFoundException $e) {
        return redirect()->route('staff.list.berkas.kkn')->with('error_message_not_found', 'Data kkn tidak ditemukan');
    }
    return view('pages.staff.berkas.berkas', compact('kkn', 'berkas'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}