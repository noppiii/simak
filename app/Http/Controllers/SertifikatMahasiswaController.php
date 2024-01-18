<?php

namespace App\Http\Controllers;

use App\Models\SertifikatKknModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SertifikatMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kknMhsId = Auth::guard('authuser')->user()->mahasiswa->kknMahasiswa->kkn_mhs_id;
        $sertifikat = SertifikatKknModel::whereHas('kknMahasiswa', function ($query) use ($kknMhsId) {
            $query->where('kkn_mhs_id', $kknMhsId);
        })->get();
        // dd($sertifikat);
        return view('pages.mahasiswa.sertifikat.index', compact('sertifikat'));
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
        //
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