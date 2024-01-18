<?php

namespace App\Http\Controllers;

use App\Http\Middleware\BatasAjuanBerkasMiddleware;
use App\Mail\AjukanBerkasLuaranMail;
use App\Models\BerkasKknModel;
use App\Models\KknMahasiswaModel;
use App\Models\KknModel;
use App\Models\LuaranModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class LuaranKknController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(BatasAjuanBerkasMiddleware::class)->only(['create']);
    }
    public function index()
    {
        try {
            // $berkasluaran = Auth::guard('authuser')->user()->mahasiswa->kknMahasiswa->luaran;
            // dd($berkasluaran);
            $mahasiswaId = Auth::guard('authuser')->user()->mahasiswa->mahasiswa_id;

            $luaran = LuaranModel::whereHas('kknMahasiswa', function ($query) use ($mahasiswaId) {
                $query->where('mahasiswa_id', $mahasiswaId);
            })->first();

            if (optional($luaran)->luaran_id) {
                $berkas = BerkasKknModel::whereHas('luaran', function ($query) use ($luaran) {
                    $query->where('luaran_id', $luaran->luaran_id);
                })->get();

                return view('pages.mahasiswa.luaran.index', compact('berkas'));
            }
            return view('pages.mahasiswa.luaran.index');
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('luaran.index')->with('error_message_not_found', 'Data mahasiswa tidak ditemukan');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.mahasiswa.luaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'nama' => 'required',
            'nim' => 'required|numeric',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nama_kegiatan' => 'required',
            'tanggal_dimulai' => 'required',
            'tanggal_diakhir' => 'required',
            'link_berkas' => 'required',
            'file_berkas.*' => 'required|mimes:pdf,doc,docx|max:20480',
        ];

        $customMessages = [
            'nama.required' => 'Nama mahasiswa tidak boleh kosong!!!',
            'nim.required' => 'NIM mahasiswa tidak boleh kosong!!!',
            'nim.numeric' => 'NIM mahasiswa tidak sesuai format (harus berupa angka)!!!',
            'tempat_lahir.required' => 'Tempat lahir tidak boleh kosong!!!',
            'tanggal_lahir.required' => 'Tanggal lahir tidak boleh kosong!!!',
            'nama_kegiatan.required' => 'Nama kegiatan tidak boleh kosong!!!',
            'tanggal_dimulai.required' => 'Tanggal dimulai kegiatan tidak boleh kosong!!!',
            'tanggal_diakhir.required' => 'Tanggal diakhir kegiatan tidak boleh kosong!!!',
            'link_berkas.required' => 'Link URL tidak boleh kosong!!!',
            'file_berkas.*.required' => 'File berkas tidak boleh kosong!!!',
            'file_berkas.*.mimes' => 'Format document tidak diizinkan.',
            'file_berkas.*.max' => 'Ukuran file tidak boleh melebihi 20MB.',
        ];

        $this->validate($request, $rules, $customMessages);

        try {
            $luaranId = Uuid::uuid4()->toString();
            $luaran = new LuaranModel();
            $luaran->luaran_id = $luaranId;
            $luaran->kkn_mhs_id = Auth::guard('authuser')->user()->mahasiswa->kknMahasiswa->kkn_mhs_id;
            $luaran->nama = $data['nama'];
            $luaran->nim = $data['nim'];
            $luaran->tempat_lahir = $data['tempat_lahir'];
            $luaran->tanggal_lahir = $data['tanggal_lahir'];
            $luaran->nama_kegiatan = $data['nama_kegiatan'];
            $luaran->tanggal_dimulai = $data['tanggal_dimulai'];
            $luaran->tanggal_diakhir = $data['tanggal_diakhir'];
            $luaran->save();

            foreach ($data['link_berkas'] as $linkBerkas) {
                $berkas = new BerkasKknModel();
                $berkas->berkas_id = Uuid::uuid4()->toString();
                $berkas->link_berkas = $linkBerkas;
                $berkas->file_berkas = null;
                $berkas->luaran_id = $luaranId;
                $berkas->status = 'Diserahkan';
                $berkas->save();
            }

            foreach ($request->file('file_berkas') as $uploadedFile) {
                if ($uploadedFile->isValid()) {
                    $extension = $uploadedFile->getClientOriginalExtension();
                    $allowedExtensions = ['pdf', 'doc', 'docx'];

                    if (!in_array($extension, $allowedExtensions)) {
                        return redirect()->back()->withInput()->withErrors(['file_berkas' => 'Format document tidak diizinkan.']);
                    }

                    $fileName = $uploadedFile->getClientOriginalName(); // Use the original file name
                    $filePath = 'public/store/luaran-berkas/' . $fileName;

                    // Simpan file menggunakan Storage
                    Storage::put($filePath, file_get_contents($uploadedFile));

                    $berkas = new BerkasKknModel();
                    $berkas->berkas_id = Uuid::uuid4()->toString();
                    $berkas->link_berkas = null;
                    $berkas->file_berkas = $fileName;
                    $berkas->luaran_id = $luaranId;
                    $berkas->status = 'Diserahkan';
                    $berkas->save();
                } else {
                    return redirect()->back()->withInput()->withErrors(['file_berkas' => 'Terjadi kesalahan saat mengunggah file.']);
                }
            }

            $userEmails = Auth::guard('authuser')->user()->email;
            Mail::to($userEmails)->send(new AjukanBerkasLuaranMail());
            Session::flash('success_message_create', 'Luaran berhasil diajukan');
            return redirect()->route('luaran.index');
        } catch (QueryException $e) {
            // Handle the integrity constraint violation exception (duplicate entry)
            if ($e->getCode() === 23000) {
                // Duplicate entry s
                $errorMessage = 'Uppsss Terjadi Kesalahan Cek Data Yang Anda Masukan. Silahkan Ulangi Lagi';
            } else {
                // Other database-related errors
                $errorMessage = 'Uppsss Terjadi Kesalahan Cek Data Yang Anda Masukan. Silahkan Ulangi Lagi';
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
            $luaran = BerkasKknModel::where('berkas_id', $id)
                ->firstOrFail();
                // dd($luaran->toArray());
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('luaran.index')->with('error_message_not_found', 'Data berkas luaran tidak ditemukan');
        }
        return view('pages.mahasiswa.luaran.edit', compact('luaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $luaranData = BerkasKknModel::where('berkas_id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('luaran.index')->with('error_message_not_found', 'Data berkas luaran tidak ditemukan');
        }

        $request->validate([
            'link_berkas' => 'required_without:file_berkas',
            'file_berkas' => 'required_without:link_berkas|nullable|mimes:pdf,doc,docx|max:20480',
        ], [
            'link_berkas.required_without' => 'Link berkas URL harus diisi jika tidak mengunggah file!!!',
            'file_berkas.required_without' => 'File berkas harus diunggah jika tidak menggunakan link berkas!!!',
            'file_berkas.mimes' => 'Format dokumen tidak diizinkan.',
            'file_berkas.max' => 'Ukuran file tidak boleh melebihi 20MB.',
        ]);

        if ($request->hasFile('file_berkas')) {
            $uploadedFile = $request->file('file_berkas');
            if ($uploadedFile->isValid()) {
                $extension = $uploadedFile->getClientOriginalExtension();
                $allowedExtensions = ['pdf', 'doc', 'docx'];

                if (!in_array($extension, $allowedExtensions)) {
                    return redirect()->back()->withInput()->withErrors(['file_berkas' => 'Format document tidak diizinkan.']);
                }

                $fileName = $uploadedFile->getClientOriginalName(); // Use the original file name
                $filePath = 'public/store/luaran-berkas/' . $fileName;


                // Delete the existing file if it exists
                if ($luaranData->file_berkas && Storage::disk('public')->exists('/store/luaran-berkas/' . $luaranData->file_berkas)) {
                    Storage::disk('public')->delete('/store/luaran-berkas/' . $luaranData->file_berkas);
                }

                // Simpan file menggunakan Storage
                Storage::put($filePath, file_get_contents($uploadedFile));
                // Update the existing entry or assign the file_berkas to the task
                $luaranData->file_berkas = $fileName;
                $luaranData->status = 'Diserahkan';
                $luaranData->save();
            } else {
                return redirect()->back()->withInput()->withErrors(['file' => 'Terjadi kesalahan saat mengunggah file.']);
            }
        } elseif ($request->filled('link_berkas')) {
            // Handle the link_berkas update separately
            $luaranData->link_berkas = $request->input('link_berkas');
            $luaranData->status = 'Diserahkan';
            $luaranData->save();
        }

        try {
            Session::flash('success_message_create', 'Data berkas luaran berhasil diperbarui');
            return redirect()->route('luaran.index');
        } catch (QueryException $e) {
            $errorMessage = 'Uppsss Terjadi Kesalahan Cek Data Yang Anda Masukan. Silahkan Ulangi Lagi';
            return redirect()->back()->withInput()->withErrors([$errorMessage]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

       //
    }
}