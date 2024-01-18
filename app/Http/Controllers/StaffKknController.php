<?php

namespace App\Http\Controllers;

use App\Models\DesaModel;
use App\Models\KabupatenModel;
use App\Models\KecamatanModel;
use App\Models\KknModel;
use App\Models\PeriodeModel;
use App\Models\PersyaratanModel;
use App\Models\SkemaModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class StaffKknController extends Controller
{

    public function index()
    {
        $kkn = KknModel::all();
        return view('pages.staff.kkn.index', compact('kkn'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desa = DesaModel::all();
        $periode = PeriodeModel::all();
        $skema = SkemaModel::all();
        return view('pages.staff.kkn.create', compact('desa', 'periode', 'skema'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'nama' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'desa_id' => 'required|exists:desas,desa_id',
            'periode_id' => 'required|exists:periodes,periode_id',
            'skema_id' => 'required|exists:skemas,skema_id',
            'nama_persyaratan' => 'required',
        ];

        $customMessages = [
            'nama.required' => 'Nama KKN harus diisi!!!',
            'deskripsi.required' => 'Deskripsi harus diisi!!!',
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi!!!',
            'tanggal_selesai.required' => 'Tanggal selesai harus diisi!!!',
            'desa_id.required' => 'Silakan pilih lokasi KKN.',
            'desa_id.exists' => 'Lokasi KKN yang dipilih tidak ada.',
            'periode_id.required' => 'Silakan pilih periode KKN.',
            'periode_id.exists' => 'Periode KKN yang dipilih tidak ada.',
            'skema_id.required' => 'Silakan pilih skema KKN.',
            'skema_id.exists' => 'Skema KKN yang dipilih tidak ada.',
            'nama_persyaratan.required' => 'Persyaratan KKN harus diisi mini 1 persyaratan!!!',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->all();
        try {
            $kknId = Uuid::uuid4()->toString();
            $kkn = new KknModel();
            $kkn->kkn_id = $kknId;
            $kkn->nama = $data['nama'];
            $kkn->deskripsi = $data['deskripsi'];
            $kkn->tanggal_mulai = $data['tanggal_mulai'];
            $kkn->tanggal_selesai = $data['tanggal_selesai'];
            $kkn->tanggal_pendaftaran = $data['tanggal_pendaftaran'];
            $kkn->skema_id = $data['skema_id'];
            $kkn->desa_id = $data['desa_id'];
            $kkn->periode_id = $data['periode_id'];
            $kkn->status = 'Belum Dimulai';
            $kkn->save();

            foreach ($data['nama_persyaratan'] as $persyaratan) {
                $syarat = new PersyaratanModel();
                $syarat->persyaratan_id = Uuid::uuid4()->toString();
                $syarat->kkn_id = $kknId;
                $syarat->nama = $persyaratan;
                $syarat->save();
            }

            Session::flash('success_message_create', 'Data kkn berhasil disimpan');
            return redirect()->route('kuliah-kerja-nyata.index');
        } catch (QueryException $e) {
            // Handle the integrity constraint violation exception (duplicate entry)
            if ($e->getCode() === 23000) {
                // Duplicate entry error
                $errorMessage = 'Upsss Terjadi Kesalahan. Silakan masukan yang berbeda.';
            } else {
                // Other database-related errors
                $errorMessage = 'Upsss Terjadi Kesalahan. Silakan masukan yang berbeda.';
            }

            return redirect()->back()->withInput()->withErrors([$errorMessage]);
        }
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
        try {
            $kkn = KknModel::where('kkn_id', $id)
                ->firstOrFail();
            $desa = DesaModel::all();
            $periode = PeriodeModel::all();
            $skema = SkemaModel::all();
            $persyaratan = PersyaratanModel::where('kkn_id', $id)->get();
                // dd($kkn->toArray());
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('kuliah-kerja-nyata.index')->with('error_message_not_found', 'Data kkn tidak ditemukan');
        }
        return view('pages.staff.kkn.edit', compact('kkn', 'desa', 'periode', 'skema', 'persyaratan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $kkn = KknModel::where('kkn_id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('kuliah-kerja-nyata.index')->with('error_message_not_found', 'Data kkn tidak ditemukan');
        }

        $data = $request->all();

        $rules = [
            'nama' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'desa_id' => 'required|exists:desas,desa_id',
            'periode_id' => 'required|exists:periodes,periode_id',
            'skema_id' => 'required|exists:skemas,skema_id',
            'nama_persyaratan.*' => 'required', // validasi untuk setiap elemen array
        ];

        $customMessages = [
            'nama.required' => 'Nama KKN harus diisi!!!',
            'deskripsi.required' => 'Deskripsi harus diisi!!!',
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi!!!',
            'tanggal_selesai.required' => 'Tanggal selesai harus diisi!!!',
            'desa_id.required' => 'Silakan pilih lokasi KKN.',
            'desa_id.exists' => 'Lokasi KKN yang dipilih tidak ada.',
            'periode_id.required' => 'Silakan pilih periode KKN.',
            'periode_id.exists' => 'Periode KKN yang dipilih tidak ada.',
            'skema_id.required' => 'Silakan pilih skema KKN.',
            'skema_id.exists' => 'Skema KKN yang dipilih tidak ada.',
            'nama_persyaratan.*.required' => 'Persyaratan KKN harus diisi!',
        ];

        $this->validate($request, $rules, $customMessages);

        try {
            // Update atribut KKN
            $kkn->nama = $data['nama'];
            $kkn->deskripsi = $data['deskripsi'];
            $kkn->tanggal_mulai = $data['tanggal_mulai'];
            $kkn->tanggal_selesai = $data['tanggal_selesai'];
            $kkn->tanggal_pendaftaran = $data['tanggal_pendaftaran'];
            $kkn->skema_id = $data['skema_id'];
            $kkn->desa_id = $data['desa_id'];
            $kkn->periode_id = $data['periode_id'];
            $kkn->status = $data['status'];
            $kkn->save();

            $kkn->persyaratans()->delete();

            // Simpan persyaratan baru
            foreach ($data['nama_persyaratan'] as $persyaratan) {
                $syarat = new PersyaratanModel();
                $syarat->persyaratan_id = Uuid::uuid4()->toString();
                $syarat->kkn_id = $kkn->kkn_id;
                $syarat->nama = $persyaratan;
                $syarat->save();
            }

            Session::flash('success_message_update', 'Data kkn berhasil diperbarui');
            return redirect()->route('kuliah-kerja-nyata.index');
        } catch (QueryException $e) {
            // Handle the integrity constraint violation exception (duplicate entry)
            if ($e->getCode() === 23000) {
                // Duplicate entry error
                $errorMessage = 'Terdapat data duplikat dari data kami. Silakan masukan yang berbeda.';
            } else {
                // Other database-related errors
                $errorMessage = 'Terdapat data duplikat dari data kami. Silakan masukan yang berbeda.';
            }

            return redirect()->back()->withInput()->withErrors([$errorMessage]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kkn = KknModel::findOrFail($id);
            // if ($kkn->kknmhses()->count() > 0) {
            //     $errorMessage = "Tidak dapat menghapus Data kkn karena terdapat data kkn terkait di data lain.";
            //     return redirect()->route('kkn.index')->with('error_message_delete', $errorMessage);
            // }
            $kkn->persyaratans()->delete();
            $kkn->delete();

            return redirect()->route('kuliah-kerja-nyata.index')->with('success_message_delete', 'Data kkn berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('kuliah-kerja-nyata.index')->with('error_message_not_found', 'Data kkn tidak ditemukan');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                 $errorMessage = "Tidak dapat menghapus Data kkn karena terdapat data kkn terkait di data lain.";
            } else {
                $errorMessage = "Terjadi kesalahan dalam menghapus Data kkn.";
            }

            return redirect()->route('kuliah-kerja-nyata.index')->with('error_message_delete', $errorMessage);
        }
   }
}