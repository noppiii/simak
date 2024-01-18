<?php

namespace App\Http\Controllers;

use App\Models\FakultasModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fakultas = FakultasModel::all();
        return view('pages.admin.fakultas.index', compact('fakultas'));
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
        $data = $request->all();

        $rules = [
            'nama' => 'required',
        ];

        $customMessages = [
            'nama.required' => 'Nama fakultas harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->all();
        try {
            $fakultas = new FakultasModel();
            $fakultas->fakultas_id = Uuid::uuid4()->toString();
            $fakultas->nama = $data['nama'];
            $fakultas->save();

            Session::flash('success_message_create', 'Data fakultas berhasil disimpan');
            return redirect()->route('fakultas.index');
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
       //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $fakultas = FakultasModel::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('fakultas.index')->with('error_message_not_found', 'Data fakultas tidak ditemukan');
        }
        $data = $request->all();

        $rules = [
            'nama' => 'required',
        ];

        $customMessages = [
            'nama.required' => 'Nama fakultas harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);

        try {
            $fakultas->nama  = $data['nama'];
            $fakultas->save();

            Session::flash('success_message_create', 'Data fakultas berhasil diperbarui');
            return redirect()->route('fakultas.index');
        } catch (QueryException $e) {
            // Handle the integrity constraint violation exception (duplicate entry)
            if ($e->getCode() === 23000) {
                // Duplicate entry error
                $errorMessage = 'Upppss Terjadi Kesalahan. Silahkan Ulangi Lagi.';
            } else {
                // Other database-related errors
                $errorMessage = 'Upppss Terjadi Kesalahan. Silahkan Ulangi Lagi.';
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
            $fakultas = FakultasModel::findOrFail($id);
            if ($fakultas->prodis()->count() > 0 ) {
                $errorMessage = "Tidak dapat menghapus Data fakultas karena terdapat data fakultas terkait di data lain.";
                return redirect()->route('fakultas.index')->with('error_message_delete', $errorMessage);
            }
            $fakultas->delete();

            return redirect()->route('fakultas.index')->with('success_message_delete', 'Data fakultas berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('fakultas.index')->with('error_message_not_found', 'Data fakultas tidak ditemukan');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                 $errorMessage = "Tidak dapat menghapus Data fakultas karena terdapat data fakultas terkait di data lain.";
            } else {
                $errorMessage = "Terjadi kesalahan dalam menghapus Data fakultas.";
            }

            return redirect()->route('fakultas.index')->with('error_message_delete', $errorMessage);
        }
    }
}