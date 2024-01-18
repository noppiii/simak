<?php

namespace App\Http\Controllers;

use App\Models\FakultasModel;
use App\Models\ProdiModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodi = ProdiModel::all();
        return view('pages.admin.prodi.index', compact('prodi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fakultas = FakultasModel::all();
        return view('pages.admin.prodi.create', compact('fakultas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'nama' => 'required',
            'fakultas_id' => 'required|exists:fakultases,fakultas_id',
        ];

        $customMessages = [
            'nama.required' => 'Nama program studi harus diisi!!!',
            'fakultas_id.required' => 'Silakan pilih fakultas.',
            'fakultas_id.exists' => 'Fakultas yang dipilih tidak ada.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->all();
        try {
            $prodi = new ProdiModel();
            $prodi->prodi_id = Uuid::uuid4()->toString();
            $prodi->nama = $data['nama'];
            $prodi->fakultas_id = $data['fakultas_id'];
            $prodi->save();

            Session::flash('success_message_create', 'Data program studi berhasil disimpan');
            return redirect()->route('program-studi.index');
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
            $prodi = ProdiModel::where('prodi_id', $id)
                ->firstOrFail();
            $fakultas = FakultasModel::all();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('program-studi.index')->with('error_message_not_found', 'Data program studi tidak ditemukan');
        }
        return view('pages.admin.prodi.edit', compact('prodi', 'fakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $prodi = ProdiModel::where('prodi_id', $id)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('program-studi.index')->with('error_message_not_found', 'Data program studi tidak ditemukan');
        }


        $data = $request->all();

        $rules = [
            'nama' => 'required',
            'fakultas_id' => 'required|exists:fakultases,fakultas_id',
        ];

        $customMessages = [
            'nama.required' => 'Nama program studi harus diisi!!!',
            'fakultas_id.required' => 'Silakan pilih fakultas.',
            'fakultas_id.exists' => 'Fakultas yang dipilih tidak ada.',
        ];

        $this->validate($request, $rules, $customMessages);

        try {
             $prodi->nama = $data['nama'];
             $prodi->fakultas_id = $data['fakultas_id'];
            if ($prodi->isDirty()) {
                $prodi->save();
            }

            Session::flash('success_message_update', 'Data program studi berhasil diperbarui');
            return redirect()->route('program-studi.index');
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
            $prodi = ProdiModel::findOrFail($id);
            if ($prodi->dpls()->count() > 0 || $prodi->mahasiswas()->count() > 0) {
                $errorMessage = "Tidak dapat menghapus Data program studi karena terdapat data program studi terkait di data lain.";
                return redirect()->route('program-studi.index')->with('error_message_delete', $errorMessage);
            }
            $prodi->delete();

            return redirect()->route('program-studi.index')->with('success_message_delete', 'Data program studi berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('program-studi.index')->with('error_message_not_found', 'Data program studi tidak ditemukan');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                 $errorMessage = "Tidak dapat menghapus Data program studi karena terdapat data program studi terkait di data lain.";
            } else {
                $errorMessage = "Terjadi kesalahan dalam menghapus Data program studi.";
            }

            return redirect()->route('program-studi.index')->with('error_message_delete', $errorMessage);
        }
    }
}