<?php

namespace App\Http\Controllers;

use App\Models\KabupatenModel;
use App\Models\KecamatanModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class StaffKecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kecamatan = KecamatanModel::all();
        return view('pages.staff.kecamatan.index', compact('kecamatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kabupaten = KabupatenModel::all();
        return view('pages.staff.kecamatan.create', compact('kabupaten'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'nama' => 'required',
            'kabupaten_id' => 'required|exists:kabupatens,kabupaten_id',
        ];

        $customMessages = [
            'nama.required' => 'Nama kecamatan harus diisi!!!',
            'kabupaten_id.required' => 'Silakan pilih kabupaten.',
            'kabupaten_id.exists' => 'Kabupaten yang dipilih tidak ada.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->all();
        try {
            $kecamatan = new KecamatanModel();
            $kecamatan->kecamatan_id = Uuid::uuid4()->toString();
            $kecamatan->nama = $data['nama'];
            $kecamatan->kabupaten_id = $data['kabupaten_id'];
            $kecamatan->save();

            Session::flash('success_message_create', 'Data kecamatan berhasil disimpan');
            return redirect()->route('daerah-kecamatan.index');
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
            $kecamatan = KecamatanModel::where('kecamatan_id', $id)
                ->firstOrFail();
            $kabupaten = KabupatenModel::all();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('daerah-kecamatan.index')->with('error_message_not_found', 'Data kecamatan tidak ditemukan');
        }
        return view('pages.staff.kecamatan.edit', compact('kecamatan', 'kabupaten'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $kecamatan = KecamatanModel::where('kecamatan_id', $id)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('daerah-kecamatan.index')->with('error_message_not_found', 'Data kecamatan tidak ditemukan');
        }

        $data = $request->all();

        $rules = [
            'nama' => 'required',
            'kabupaten_id' => 'required|exists:kabupatens,kabupaten_id',
        ];

        $customMessages = [
            'nama.required' => 'Nama kecamatan harus diisi!!!',
            'kabupaten_id.required' => 'Silakan pilih kabupaten.',
            'kabupaten_id.exists' => 'Kabupaten yang dipilih tidak ada.',
        ];

        $this->validate($request, $rules, $customMessages);

        try {
             $kecamatan->nama = $data['nama'];
             $kecamatan->kabupaten_id = $data['kabupaten_id'];
            if ($kecamatan->isDirty()) {
                $kecamatan->save();
            }

            Session::flash('success_message_update', 'Data kecamatan berhasil diperbarui');
            return redirect()->route('daerah-kecamatan.index');
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
            $kecamatan = KecamatanModel::findOrFail($id);
            if ($kecamatan->desas()->count() > 0) {
                $errorMessage = "Tidak dapat menghapus Data kecamatan karena terdapat data kecamatan terkait di data lain.";
                return redirect()->route('daerah-kecamatan.index')->with('error_message_delete', $errorMessage);
            }
            $kecamatan->delete();

            return redirect()->route('daerah-kecamatan.index')->with('success_message_delete', 'Data kecamatan berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('daerah-kecamatan.index')->with('error_message_not_found', 'Data kecamatan tidak ditemukan');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                 $errorMessage = "Tidak dapat menghapus Data kecamatan karena terdapat data kecamatan terkait di data lain.";
            } else {
                $errorMessage = "Terjadi kesalahan dalam menghapus Data kecamatan.";
            }

            return redirect()->route('daerah-kecamatan.index')->with('error_message_delete', $errorMessage);
        }
    }
}