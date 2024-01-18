<?php

namespace App\Http\Controllers;

use App\Models\KabupatenModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class KabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kabupaten = KabupatenModel::all();
        return view('pages.admin.kabupaten.index', compact('kabupaten'));
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
            'nama.required' => 'Nama kabupaten harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->all();
        try {
            $kabupaten = new KabupatenModel();
            $kabupaten->kabupaten_id = Uuid::uuid4()->toString();
            $kabupaten->nama = $data['nama'];
            $kabupaten->save();

            Session::flash('success_message_create', 'Data kabupaten berhasil disimpan');
            return redirect()->route('wilayah-kabupaten.index');
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
            $kabupaten = KabupatenModel::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('wilayah-kabupaten.index')->with('error_message_not_found', 'Data kabupaten tidak ditemukan');
        }
        $data = $request->all();

        $rules = [
            'nama' => 'required',
        ];

        $customMessages = [
            'nama.required' => 'Nama kabupaten harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);

        try {
            $kabupaten->nama  = $data['nama'];
            $kabupaten->save();

            Session::flash('success_message_create', 'Data kabupaten berhasil diperbarui');
            return redirect()->route('wilayah-kabupaten.index');
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
            $kabupaten = KabupatenModel::findOrFail($id);
            if ($kabupaten->kecamatans()->count() > 0) {
                $errorMessage = "Tidak dapat menghapus Data kabupaten karena terdapat data kabupaten terkait di data lain.";
                return redirect()->route('wilayah-kabupaten.index')->with('error_message_delete', $errorMessage);
            }
            $kabupaten->delete();

            return redirect()->route('wilayah-kabupaten.index')->with('success_message_delete', 'Data kabupaten berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('wilayah-kabupaten.index')->with('error_message_not_found', 'Data kabupaten tidak ditemukan');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                 $errorMessage = "Tidak dapat menghapus Data kabupaten karena terdapat data kabupaten terkait di data lain.";
            } else {
                $errorMessage = "Terjadi kesalahan dalam menghapus Data kabupaten.";
            }

            return redirect()->route('wilayah-kabupaten.index')->with('error_message_delete', $errorMessage);
        }
    }
}