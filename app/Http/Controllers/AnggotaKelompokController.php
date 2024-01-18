<?php

namespace App\Http\Controllers;

use App\Models\DplModel;
use App\Models\KknMahasiswaModel;
use App\Models\KknModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AnggotaKelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $nama, string $periode, string $id)
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

            $dpl = DplModel::all();

            // dd($mahasiswaList->toArray());
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('list.kkn.mhs')->with('error_message_not_found', 'Data kkn tidak ditemukan');
        }
        return view('pages.admin.anggota-kelompok.index', compact('kkn', 'mahasiswaList', 'dpl'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $nama, string $periode, string $id)
    {
        $kkn = KknModel::where('nama', $nama)
        ->whereHas('periode', function ($query) use ($periode) {
            $query->where('nama', $periode);
        })
        ->firstOrFail();

        $mahasiswaList = $kkn->kknMahasiswas->filter(function ($kknMahasiswa) {
            return $kknMahasiswa->kelompok_id === null;
        });
        // dd($mahasiswaList->toArray());
        return view('pages.admin.anggota-kelompok.create', compact('kkn', 'mahasiswaList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $nama, string $periode)
    {
        $rules = [
            'kelompok_id' => 'required|exists:kkn_mahasiswas,mahasiswa_id', // Change kelompok_id to mahasiswa_id
        ];

        $customMessages = [
            'kelompok_id.required' => 'Silakan pilih peserta.',
            'kelompok_id.exists' => 'Peserta yang dipilih tidak ada.',
        ];

        $this->validate($request, $rules, $customMessages);

        try {
            // Ambil mahasiswa_id dari request
            $mahasiswaId = $request->input('kelompok_id');
            $kelompokId = request()->route('kelompok_id');

            // Perbarui kelompok_id pada kkn_mahasiswas
            KknMahasiswaModel::where('mahasiswa_id', $mahasiswaId)
                ->update(['kelompok_id' => $kelompokId]);

            Session::flash('success_message_create', 'Data mahasiswa berhasil ditambahkan ke kelompok');
            return redirect()->route('list.anggota.kelompok', [
                'nama' => $nama,
                'periode' => $periode,
                'kelompok_id' => $kelompokId,
            ]);;
        } catch (QueryException $e) {
            // Handle the integrity constraint violation exception (duplicate entry)
            if ($e->getCode() === 23000) {
                // Duplicate entry error
                $errorMessage = 'Upsss Terjadi Kesalahan Silahkan Coba Lagi!!!';
            } else {
                // Other database-related errors
                $errorMessage = 'Upsss Terjadi Kesalahan Silahkan Coba Lagi!!!';
            }

            return redirect()->back()->withInput()->withErrors([$errorMessage]);
        }
    }

    public function editDpl(Request $request)
    {

        try {
            // Ambil mahasiswa_id dari request
            $dplId = $request->input('dpl_id');
            $kelompokId = request()->route('kelompok_id');

            // Perbarui kelompok_id pada kkn_mahasiswas
            KknMahasiswaModel::where('kelompok_id', $kelompokId)
                ->update(['dpl_id' => $dplId]);

            Session::flash('success_message_create', 'Data dpl berhasil diperbaruhi');
            return redirect()->back();
        } catch (QueryException $e) {
            // Handle the integrity constraint violation exception (duplicate entry)
            if ($e->getCode() === 23000) {
                // Duplicate entry error
                $errorMessage = 'Upsss Terjadi Kesalahan Silahkan Coba Lagi!!!';
            } else {
                // Other database-related errors
                $errorMessage = 'Upsss Terjadi Kesalahan Silahkan Coba Lagi!!!';
            }

            return redirect()->back()->withInput()->withErrors([$errorMessage]);
        }
    }

    public function deleteAnggota(string $nama, string $periode, string $kelompokId, string $mahasiswaId)
    {
        // try {
            // Step 1: Temukan kkn beserta periodenya
            $kkn = KknModel::where('nama', $nama)
                ->whereHas('periode', function ($query) use ($periode) {
                    $query->where('nama', $periode);
                })
                ->firstOrFail();

            // Step 2: Tentukan kelompok berdasarkan route
            $kelompokId = request()->route('kelompok_id');

            // Step 3: Cari mahasiswa_id
            $mahasiswa = $kkn->kknMahasiswas
             ->firstWhere('mahasiswa_id', $mahasiswaId)
             ->where('kelompok_id', $kelompokId);

            if (!$mahasiswa) {
                // Handle case when mahasiswa is not found
                throw new \Exception('Mahasiswa not found.');
            }

            // Step 4: Setelah mahasiswa_id nya ditemukan, set kelompok_id menjadi null
            KknMahasiswaModel::where('mahasiswa_id', $mahasiswaId)
                ->update(['kelompok_id' => null]);

            // Flash success message
            Session::flash('success_message_delete', 'Data mahasiswa berhasil dihapus dari kelompok');
            return redirect()->back();
        // } catch (\Exception $e) {
        //     // Handle exceptions (e.g., mahasiswa not found)
        //     $errorMessage = 'Upsss Terjadi Kesalahan Silahkan Coba Lagi!!!';
        //     return redirect()->back()->withInput()->withErrors([$errorMessage]);
        // }
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