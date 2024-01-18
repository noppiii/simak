<?php

namespace App\Http\Controllers;

use App\Models\KknMahasiswaModel;
use App\Models\KknModel;
use App\Models\SkemaModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $skema = SkemaModel::all();
    $search = $request->input('searchkKn');
    $selectedSkema = $request->input('skema');
    $dosenId = Auth::guard('authuser')->user()->dpl->dpl_id;
    $kknDplId = KknMahasiswaModel::where('dpl_id', $dosenId)->get();
    $kknIds = [];
    foreach ($kknDplId as $kknMahasiswa) {
        $kknIds[] = $kknMahasiswa['kkn_id'];
    }

    $kknQuery = KknModel::with(['skema'])->whereIn('kkn_id', $kknIds);

    // dd($kknQuery->toArray());

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

    $kkn = $kknQuery->paginate(10);

    return view('pages.dosen.penilaian.index', compact('skema', 'kkn', 'search', 'selectedSkema'));
}

public function kelompok(string $nama, string $periode)
    {
        try {
            $dosenId = Auth::guard('authuser')->user()->dpl->dpl_id;
            $kkn = KknModel::where('nama', $nama)
            ->whereHas('periode', function ($query) use ($periode) {
                $query->where('nama', $periode);
            })
            ->firstOrFail();
            $mahasiswaList = $kkn->kknMahasiswas->map(function ($kknMahasiswa) {
                return $kknMahasiswa->mahasiswa;
            });
            $kknDpl = $kkn->kknMahasiswas->filter(function ($kknMahasiswa) use ($dosenId) {
                return $kknMahasiswa->dpl_id == $dosenId;
            });
            $kknDpl = $kkn->kknMahasiswas->filter(function ($kknMahasiswa) use ($dosenId) {
                return $kknMahasiswa->dpl_id == $dosenId;
            });
            $kelompokList = $kknDpl->filter(function ($kknMahasiswa) {
                return $kknMahasiswa->kelompok != null;
            })->pluck('kelompok')->unique();
            // dd($kkn->toArray());
            // dd($kelompokList->toArray());
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dosen.list.kkn.mhs')->with('error_message_not_found', 'Data kkn tidak ditemukan');
        }
        return view('pages.dosen.penilaian.kelompok', compact('kkn', 'mahasiswaList', 'kelompokList'));
    }

    public function allPeserta(string $nama, string $periode, string $id)
    {
        try {
            $kkn = KknModel::where('nama', $nama)
            ->whereHas('periode', function ($query) use ($periode) {
                $query->where('nama', $periode);
            })
            ->firstOrFail();

            $mahasiswaList = $kkn->kknMahasiswas()
            ->where('kelompok_id', $id)
            ->get()
            ->map->mahasiswa;

            // dd($mahasiswaList->toArray());
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('list.kkn.mhs')->with('error_message_not_found', 'Data kkn tidak ditemukan');
        }
        return view('pages.dosen.penilaian.list-anggota', compact('kkn', 'mahasiswaList'));
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