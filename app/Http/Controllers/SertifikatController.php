<?php

namespace App\Http\Controllers;

use App\Models\KknModel;
use App\Models\LuaranModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\SkemaModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $skema = SkemaModel::all();
    $search = $request->input('searchkKn');
    $selectedSkema = $request->input('skema');

    $kknQuery = KknModel::with(['skema']);

    // Pencarian berdasarkan nama, desa, kecamatan, kabupaten, atau periode
    if ($search) {
        $kknQuery->where(function ($query) use ($search) {
            $query->where('nama', 'LIKE', '%' . $search . '%')
                ->orWhereHas('desa', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('desa.kecamatan', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('desa.kecamatan.kabupaten', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('periode', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', '%' . $search . '%');
                });
        });
    }

    if ($selectedSkema) {
        $kknQuery->whereHas('skema', function ($subquery) use ($selectedSkema) {
            $subquery->where('nama', $selectedSkema);
        });
    }
    $kkn = $kknQuery->paginate(10);
    // dd($kkn->toArray());
    return view('pages.admin.sertifikat.index', compact('skema', 'kkn', 'search', 'selectedSkema'));
    }

    public function mahasiswa(Request $request, string $nama, string $periode)
    {
        try {
            $search = $request->input('searchkKn');
            $selectedProdi = $request->input('prodi');

            $kkn = KknModel::where('nama', $nama)
            ->whereHas('periode', function ($query) use ($periode) {
                $query->where('nama', $periode);
            })
            ->firstOrFail();

        $prodi = $kkn->kknMahasiswas->map(function ($kknMahasiswa) {
            return $kknMahasiswa->mahasiswa->prodi;
        });

        $mahasiswaKkn = $this->getFilteredMahasiswaList($kkn, $search, $selectedProdi);

        $mahasiswaList = $kkn->kknMahasiswas->pluck('mahasiswa');
        $mahasiswaList = $mahasiswaList->filter(function ($mahasiswa) use ($mahasiswaKkn) {
            return $mahasiswaKkn->contains('mahasiswa_id', $mahasiswa->mahasiswa_id);
        });

        $mahasiswaIds = $mahasiswaList->pluck('mahasiswa_id')->toArray();
        $mahasiswaList = MahasiswaModel::whereIn('mahasiswa_id', $mahasiswaIds)->paginate(10);

        // dd($mahasiswaList->toArray());

            return view('pages.admin.sertifikat.list-mahasiswa', compact('kkn', 'mahasiswaList', 'prodi', 'search', 'selectedProdi'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('list.sertifikat.kkn')->with('error_message_not_found', 'Data kkn tidak ditemukan');
        }
    }

    private function getFilteredMahasiswaList(KknModel $kkn, $search, $selectedProdi)
{
    $mahasiswaQuery = MahasiswaModel::where(function ($query) use ($search) {
        $query->where('nama', 'LIKE', '%' . $search . '%')
            ->orWhere('nim', 'LIKE', '%' . $search . '%')
            ->orWhere('jenis_kelamin', 'LIKE', '%' . $search . '%')
            ->orWhere('telp', 'LIKE', '%' . $search . '%')
            ->orWhere('alamat', 'LIKE', '%' . $search . '%')
            ->orWhereHas('prodi', function ($query) use ($search) {
                $query->where('nama', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('prodi.fakultas', function ($query) use ($search) {
                $query->where('nama', 'LIKE', '%' . $search . '%');
            });
    });

    // Jika ada prodi dipilih, tambahkan filter prodi
    if ($selectedProdi) {
        $mahasiswaQuery->whereHas('prodi', function ($subquery) use ($selectedProdi) {
            $subquery->where('nama', $selectedProdi);
        });
    }

    // Assuming that kknMahasiswas relationship is loaded efficiently
    $perPage = 10; // Jumlah item per halaman
    $mahasiswaList = $mahasiswaQuery->paginate($perPage);

    // Mengambil query string dari URL dan menambahkannya ke hasil pagination
    $mahasiswaList->appends(request()->query());

    return $mahasiswaList;
}

public function process(Request $request) {
    $nama = $request->input('nama');
    $nim = $request->input('nim');
    $tempatTanggalLahir = $request->input('tempat_tanggal_lahir');
    $fakultasProdi = $request->input('fakultas_prodi');
    $namaKegiatan = $request->input('nama_kegiatan');
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalSelesai = $request->input('tanggal_selesai');
    $nilai = $request->input('nilai');
    $tanggalDibuat = $request->input('tanggal_dibuat');

    $templateFile = public_path() . '/storage/store/sertifikat/input/sertifikat.pdf';
    $outputfile = public_path() . '/storage/store/sertifikat/sertifikat-$nim.pdf';
    $this->fillPDF($templateFile, $outputfile, $nama, $nim, $tempatTanggalLahir, $fakultasProdi, $namaKegiatan, $tanggalMulai, $tanggalSelesai, $nilai, $tanggalDibuat);

    return response()->file($outputfile);
}


public function fillPDF($file, $outputfile, $nama, $nim, $tempatTanggalLahir, $fakultasProdi, $namaKegiatan, $tanggalMulai, $tanggalSelesai, $nilai, $tanggalDibuat) {
    $fpdi = new Fpdi();
    $fpdi->setSourceFile($file);
    $template = $fpdi->importPage(1);
    $size = $fpdi->getTemplateSize($template);
    $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
    $fpdi->useTemplate($template);

    $top = 105;
    $right = 135;
    $maxWidth = 200;

    // Fill additional form inputs
    $fpdi->SetFont('helvetica', "", 17);
    $fpdi->SetTextColor(25, 26, 25);

    // Limit the length of each variable
    $maxTextLength = 30;

    // Concatenate and limit the length of the combined string
    $combinedString = substr($nama, 0, $maxTextLength) . ' ' .
                      substr($nim, 0, $maxTextLength) . ' ' .
                      substr($tempatTanggalLahir, 0, $maxTextLength) . ' ' .
                      substr($fakultasProdi, 0, $maxTextLength) . ' ' .
                      substr($namaKegiatan, 0, $maxTextLength) . ' ' .
                      substr($tanggalMulai, 0, $maxTextLength) . ' ' .
                      substr($tanggalSelesai, 0, $maxTextLength) . ' ' .
                      substr($nilai, 0, $maxTextLength) . ' ' .
                      substr($tanggalDibuat, 0, $maxTextLength);

    // Break the string into lines to fit within the max width
    $lines = $this->breakStringIntoLines($combinedString, $maxWidth);

    // Output each line separately
    $lineHeight = 8; // Adjust as needed
    foreach ($lines as $line) {
        $fpdi->Text($right, $top, $line);
        $top += $lineHeight;
    }

    return $fpdi->Output($outputfile, 'F');
}

// Custom function to break a string into lines based on max width
private function breakStringIntoLines($text, $maxWidth) {
    $lines = [];
    $currentLine = '';

    $words = explode(' ', $text);

    foreach ($words as $word) {
        $width = $this->getStringWidth($currentLine . ' ' . $word);

        if ($width <= $maxWidth) {
            $currentLine .= ' ' . $word;
        } else {
            $lines[] = trim($currentLine);
            $currentLine = $word;
        }
    }

    if (!empty($currentLine)) {
        $lines[] = trim($currentLine);
    }

    return $lines;
}

// Helper function to get string width
private function getStringWidth($text) {
    $fpdi = new Fpdi();
    $fpdi->SetFont('helvetica', '', 17);
    return $fpdi->GetStringWidth($text);
}



    /**
     * Show the form for creating a new resource.
     */
    public function create(string $nama, string $periode, string $nim)
    {
        try {
            $kkn = KknModel::where('nama', $nama)
            ->whereHas('periode', function ($query) use ($periode) {
                $query->where('nama', $periode);
            })
            ->firstOrFail();

        $mahasiswa = $kkn->kknMahasiswas->filter(function ($kknMahasiswa) use ($nim) {
            return $kknMahasiswa->mahasiswa->nim === $nim;
        });
        $kknMahasiswaIds = $mahasiswa->pluck('kkn_mhs_id')->toArray();

        $luaran = LuaranModel::whereIn('kkn_mhs_id', $kknMahasiswaIds)->get();
        $namaProdi = $mahasiswa[1]['mahasiswa']['prodi']['nama'];
        $namaFakultas = $mahasiswa[1]['mahasiswa']['prodi']['fakultas']['nama'];

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message_not_found', 'Data kkn tidak ditemukan');
        }
        return view('pages.admin.sertifikat.create', compact('kkn', 'mahasiswa' ,'luaran', 'namaProdi', 'namaFakultas'));
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