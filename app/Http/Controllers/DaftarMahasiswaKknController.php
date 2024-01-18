<?php

namespace App\Http\Controllers;

use App\Http\Middleware\BatasPendaftaranKknMiddleware;
use App\Models\KknMahasiswaModel;
use App\Models\KknModel;
use App\Models\SkemaModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class DaftarMahasiswaKknController extends Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware(BatasPendaftaranKknMiddleware::class)->only(['store']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kkn = KknModel::all();
        $skema = SkemaModel::all();
        return view('pages.mahasiswa.daftar-kkn.index', compact('kkn', 'skema'));
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
        try {
            $kkn = session('kkn_data');
            $kknMmahasiswa = new KknMahasiswaModel();
            $kknMmahasiswa->kkn_mhs_id = Uuid::uuid4()->toString();
            $kknMmahasiswa->nilai = null;
            $kknMmahasiswa->mahasiswa_id = Auth::guard('authuser')->user()->mahasiswa->mahasiswa_id;
            $kknMmahasiswa->dpl_id = null;
            $kknMmahasiswa->kkn_id = $kkn->kkn_id;
            $kknMmahasiswa->kelompok_id = null;
            $kknMmahasiswa->save();

            session()->forget('kkn_data');

            Session::flash('success_message_create', 'Anda berhasil mendaftar KKN ini');
            return redirect()->route('daftar-kkn.index');
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
    public function show(string $nama, string $periode)
    {
        try {
            $kkn = KknModel::where('nama', $nama)
            ->whereHas('periode', function ($query) use ($periode) {
                $query->where('nama', $periode);
            })
            ->firstOrFail();
            // dd($kkn->kkn_id);
            session(['kkn_data' => $kkn]);
            // dd($kkn->toArray());
            // dd(Auth::guard('authuser')->user()->mahasiswa->mahasiswa_id);
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('daftar-kkn.index')->with('error_message_not_found', 'Data kkn tidak ditemukan');
        }
        return view('pages.mahasiswa.daftar-kkn.detail', compact('kkn'));
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
