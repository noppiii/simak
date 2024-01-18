<?php

namespace App\Http\Controllers;

use App\Models\DesaModel;
use App\Models\KabupatenModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class StaffDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $desa = DesaModel::all();
        return view('pages.staff.desa.index', compact('desa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kabupaten = KabupatenModel::all();
        return view('pages.staff.desa.create', compact('kabupaten'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'nama' => 'required',
            'kecamatan_id' => 'required|exists:kecamatans,kecamatan_id',
        ];

        $customMessages = [
            'nama.required' => 'Nama kecamatan harus diisi!!!',
            'kecamatan_id.required' => 'Silakan pilih kabupaten.',
            'kecamatan_id.exists' => 'Kabupaten yang dipilih tidak ada.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->all();
        try {
            $desa = new DesaModel();
            $desa->desa_id = Uuid::uuid4()->toString();
            $desa->nama = $data['nama'];
            $desa->kecamatan_id = $data['kecamatan_id'];
            $desa->save();

            Session::flash('success_message_create', 'Data desa berhasil disimpan');
            return redirect()->route('wilayah-desa.index');
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
            $desa = DesaModel::where('desa_id', $id)
                ->firstOrFail();
                $kecamatanWithKabupaten = KabupatenModel::with('kecamatans')->get();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('wilayah-kecamatan.index')->with('error_message_not_found', 'Data kecamatan tidak ditemukan');
        }
        return view('pages.staff.desa.edit', compact('desa', 'kecamatanWithKabupaten'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $desa = DesaModel::where('DESA_ID', $id)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('wilayah-desa.index')->with('error_message_not_found', 'Data desa tidak ditemukan');
        }

        $data = $request->all();

        $rules = [
            'nama' => 'required',
            'kecamatan_id' => 'required|exists:kecamatans,kecamatan_id',
        ];

        $customMessages = [
            'nama.required' => 'Nama kecamatan harus diisi!!!',
            'kecamatan_id.required' => 'Silakan pilih kecamatan.',
            'kecamatan_id.exists' => 'Kecamatan yang dipilih tidak ada.',
        ];

        $this->validate($request, $rules, $customMessages);

        try {
             $desa->nama = $data['nama'];
             $desa->kecamatan_id = $data['kecamatan_id'];
            if ($desa->isDirty()) {
                $desa->save();
            }

            Session::flash('success_message_update', 'Data desa berhasil diperbarui');
            return redirect()->route('wilayah-desa.index');
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
            $desa = DesaModel::findOrFail($id);
            // if ($desa->kecamatan()->count() > 0) {
            //     $errorMessage = "Tidak dapat menghapus Data desa karena terdapat data desa terkait di data lain.";
            //     return redirect()->route('wilayah-desa.index')->with('error_message_delete', $errorMessage);
            // }
            $desa->delete();

            return redirect()->route('wilayah-desa.index')->with('success_message_delete', 'Data desa berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('wilayah-desa.index')->with('error_message_not_found', 'Data desa tidak ditemukan');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                 $errorMessage = "Tidak dapat menghapus Data desa karena terdapat data desa terkait di data lain.";
            } else {
                $errorMessage = "Terjadi kesalahan dalam menghapus Data desa.";
            }

            return redirect()->route('wilayah-desa.index')->with('error_message_delete', $errorMessage);
        }
    }
}