<?php

namespace App\Http\Controllers;

use App\Models\PeriodeModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periode = PeriodeModel::all();
        return view('pages.admin.periode.index', compact('periode'));
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
            'nama.required' => 'Nama periode harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->all();
        try {
            $periode = new PeriodeModel();
            $periode->periode_id = Uuid::uuid4()->toString();
            $periode->nama = $data['nama'];
            $periode->save();

            Session::flash('success_message_create', 'Data periode berhasil disimpan');
            return redirect()->route('penataan-periode.index');
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
            $periode = PeriodeModel::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('penataan-periode.index')->with('error_message_not_found', 'Data periode tidak ditemukan');
        }
        $data = $request->all();

        $rules = [
            'nama' => 'required',
        ];

        $customMessages = [
            'nama.required' => 'Nama periode harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);

        try {
            $periode->nama  = $data['nama'];
            $periode->save();

            Session::flash('success_message_create', 'Data periode berhasil diperbarui');
            return redirect()->route('penataan-periode.index');
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
            $periode = PeriodeModel::findOrFail($id);
            if ($periode->kkns()->count() > 0 ) {
                $errorMessage = "Tidak dapat menghapus Data periode karena terdapat data periode terkait di data lain.";
                return redirect()->route('penataan-periode.index')->with('error_message_delete', $errorMessage);
            }
            $periode->delete();

            return redirect()->route('penataan-periode.index')->with('success_message_delete', 'Data periode berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('penataan-periode.index')->with('error_message_not_found', 'Data periode tidak ditemukan');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                 $errorMessage = "Tidak dapat menghapus Data periode karena terdapat data periode terkait di data lain.";
            } else {
                $errorMessage = "Terjadi kesalahan dalam menghapus Data periode.";
            }

            return redirect()->route('penataan-periode.index')->with('error_message_delete', $errorMessage);
        }
    }
}