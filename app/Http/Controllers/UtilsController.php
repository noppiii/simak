<?php

namespace App\Http\Controllers;

use App\Models\KabupatenModel;
use App\Models\KecamatanModel;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
    public function responseKecamatan(string $id)
    {
        $kabupaten = KabupatenModel::findOrFail($id);
        $kecamatan = $kabupaten->kecamatans;

        return response()->json(['kecamatan' => $kecamatan]);
    }

    public function responseDesa(string $id)
    {
        $kecamatan = KecamatanModel::findOrFail($id);
        $desa = $kecamatan->desas;

        return response()->json(['desa' => $desa]);
    }
}