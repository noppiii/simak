<?php

namespace App\Http\Controllers;


use App\Models\KelompokModel;
use App\Models\KknMahasiswaModel;
use App\Models\KknModel;
use App\Models\SkemaModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Uuid\Uuid;

class StaffKknMahasiswaController extends Controller
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

    // Penapisan berdasarkan skema
    if ($selectedSkema) {
        $kknQuery->whereHas('skema', function ($subquery) use ($selectedSkema) {
            $subquery->where('nama', $selectedSkema);
        });
    }

    // Ambil data dengan paginasi
    $kkn = $kknQuery->paginate(10);

    return view('pages.staff.kkn-mahasiswa.index', compact('skema', 'kkn', 'search', 'selectedSkema'));
}

    public function kelompok(Request $request, string $nama, string $periode)
    {
        try {
            $perPage = 10;
            $search = $request->input('searchkKn');
            $kkn = KknModel::where('nama', $nama)
                ->whereHas('periode', function ($query) use ($periode) {
                    $query->where('nama', $periode);
                })
                ->firstOrFail();

            // Initial data (all kelompok, paginated)
            $kelompokList = $kkn->kknMahasiswas
                ->filter(function ($kknMahasiswa) {
                    return $kknMahasiswa->kelompok !== null;
                })
                ->pluck('kelompok')
                ->unique();

            // Search results (filtered kelompok, paginated)
            $searchedKelompokList = $kelompokList;
            if ($search) {
                $searchedKelompokList = $kelompokList->filter(function ($kelompok) use ($search) {
                    return str_contains(strtolower($kelompok['nama']), strtolower($search))
                        || $kelompok->kknMahasiswas->filter(function ($kknMahasiswa) use ($search) {
                            return str_contains(strtolower($kknMahasiswa->mahasiswa['nama']), strtolower($search))
                                || str_contains(strtolower($kknMahasiswa->mahasiswa['nim']), strtolower($search));
                        })->isNotEmpty();
                });
            }

            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $search ? $searchedKelompokList : $kelompokList;
            $pagedItems = $currentItems->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $paginatedItems = new LengthAwarePaginator($pagedItems, count($currentItems), $perPage);
            $paginatedItems->setPath($request->url());
            // dd($paginatedItems);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('staff.list.kkn.mhs')->with('error_message_not_found', 'Data kkn tidak ditemukan');
        }
        return view('pages.staff.kkn-mahasiswa.kelompok', compact('kkn', 'paginatedItems', 'search', 'kelompokList'));
    }

    public function getPesertaData($nama, $periode)
    {
        try {
            $kkn = KknModel::where('nama', $nama)
                ->whereHas('periode', function ($query) use ($periode) {
                    $query->where('nama', $periode);
                })
                ->with('kknMahasiswas.mahasiswa.prodi') // Eager load the necessary relationships
                ->firstOrFail();

            $mahasiswaList = $kkn->kknMahasiswas
                ->filter(function ($kknMahasiswa) {
                    return $kknMahasiswa->kelompok_id === null;
                })
                ->map(function ($kknMahasiswa) {
                    $mahasiswa = $kknMahasiswa->mahasiswa;

                    // You can customize the returned data structure as needed
                    return [
                        'nama' => $mahasiswa->nama,
                        'jenis_kelamin' => $mahasiswa->jenis_kelamin,
                        'nama_prodi' => $mahasiswa->prodi ? $mahasiswa->prodi->nama : null,
                    ];
                });

            return response()->json($mahasiswaList);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data peserta KKN tidak ditemukan'], 404);
        }
    }

    public function getProdiData($nama, $periode)
    {
        try {
            $kkn = KknModel::where('nama', $nama)
                ->whereHas('periode', function ($query) use ($periode) {
                    $query->where('nama', $periode);
                })
                ->firstOrFail();
            $prodiList = $kkn->kknMahasiswas->filter(function ($kknMahasiswa) {
                return $kknMahasiswa->kelompok_id === null;
            })->map(function ($kknMahasiswa) {
                return $kknMahasiswa->mahasiswa->prodi->nama;
            });

            return response()->json($prodiList);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data peserta KKN tidak ditemukan'], 404);
        }
    }

    public function generateKelompok(Request $request, $kknId) {
        $data = $request->all();
        try {
            $banyakAnggota = $request->input('banyak_anggota');
            $komposisiGender = $request->input('komposisi_gender');
            $pilihanProdi = $request->input('komposisi_prodi');
            $listAnggota = $request->input('list_anggota');
            $pilihanProdi = array_filter($pilihanProdi, function ($item) {
                return isset($item['prosentase_prodi']) && $item['prosentase_prodi'] !== null;
            });

            if (is_string($listAnggota)) {
                $listAnggota = explode(', ', $listAnggota);
            }

            $listAnggota = array_filter($listAnggota);

            $formattedAnggota = [];
            $count = count($listAnggota);

            for ($i = 0; $i < $count; $i += 2) {
                $namaDetails = explode(' (', $listAnggota[$i]);
                $nama = $namaDetails[0];
                $jenisKelaminDetails = explode(', ', rtrim($namaDetails[1], ')'));
                $jenisKelamin = $jenisKelaminDetails[0];
                $namaProdi = rtrim($listAnggota[$i + 1], ')');
                $formattedAnggota[] = [
                    'nama' => $nama,
                    'jenis_kelamin' => $jenisKelamin,
                    'nama_prodi' => $namaProdi,
                ];
            }

            $selectedAnggotaByProdi = [];
            foreach ($pilihanProdi as $prodi) {
                $targetProdi = $prodi['komposisi_prodi'];
                $targetProsentase = $prodi['prosentase_prodi'];

                $selectedAnggotaByProdi[$targetProdi] = array_filter($formattedAnggota, function ($anggota) use ($targetProdi) {
                    return strtolower($anggota['nama_prodi']) === strtolower($targetProdi);
                });

                shuffle($selectedAnggotaByProdi[$targetProdi]);

                $countProdi = ceil(count($selectedAnggotaByProdi[$targetProdi]) * ($targetProsentase / 100));

                $selectedAnggotaByProdi[$targetProdi] = array_slice($selectedAnggotaByProdi[$targetProdi], 0, $countProdi);
            }

            $selectedAnggota = [];
            foreach ($selectedAnggotaByProdi as $prodiMembers) {
                $selectedAnggota = array_merge($selectedAnggota, $prodiMembers);
            }

            if ($komposisiGender < 0 || $komposisiGender > 100) {
                throw new \Exception('Persentase komposisi tidak valid. Itu harus antara 0 dan 100.');
            }

            $lakiLaki = array_filter($selectedAnggota, function ($anggota) {
                return strpos(strtolower($anggota['jenis_kelamin']), 'laki-laki') !== false;
            });

            $perempuan = array_filter($selectedAnggota, function ($anggota) {
                return strpos(strtolower($anggota['jenis_kelamin']), 'perempuan') !== false;
            });

            $countLakiLaki = ceil(count($lakiLaki) * ($komposisiGender / 100));
            $countPerempuan = $banyakAnggota - $countLakiLaki;

            $selectedLakiLaki = array_slice($lakiLaki, 0, $countLakiLaki);
            $selectedPerempuan = array_slice($perempuan, 0, $countPerempuan);
            $selectedAnggota = array_merge($selectedLakiLaki, $selectedPerempuan);
            shuffle($selectedAnggota);

            $jumlahKelompok = ceil(count($selectedAnggota) / $banyakAnggota);

            for ($i = 0; $i < $jumlahKelompok; $i++) {
                $kelompokId = Uuid::uuid4()->toString();
                $kelompok = new KelompokModel();
                $kelompok->kelompok_id = $kelompokId;
                $kelompok->nama = 'Kelompok ' . ($i + 1);
                $kelompok->save();

                $currentAnggota = array_slice($selectedAnggota, $i * $banyakAnggota, $banyakAnggota);

                $kknMahasiswasCurrent = KknMahasiswaModel::whereIn('mahasiswa_id', function ($query) use ($currentAnggota) {
                    $query->select('mahasiswa_id')
                        ->from('mahasiswas')
                        ->whereIn('nama', array_column($currentAnggota, 'nama'));
                })
                    ->with('mahasiswa')
                    ->get();

                foreach ($kknMahasiswasCurrent as $kknMahasiswa) {
                    $kknMahasiswa->kelompok_id = $kelompokId;
                    $kknMahasiswa->dpl_id = null;
                    $kknMahasiswa->save();
                }
            }

            return redirect()->back()->with('success_message_create', 'Kelompok berhasil digenerate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'An error occurred: ' . $e->getMessage());
        }
    }



    public function allPeserta(string $nama, string $periode)
    {
        try {
            $kkn = KknModel::where('nama', $nama)
            ->whereHas('periode', function ($query) use ($periode) {
                $query->where('nama', $periode);
            })
            ->firstOrFail();

            // Get the list of Mahasiswa using the intermediate model
            $mahasiswaList = $kkn->kknMahasiswas->map(function ($kknMahasiswa) {
                return $kknMahasiswa->mahasiswa;
            });
            // dd($mahasiswaList->toArray());
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('staff.list.kkn.peserta')->with('error_message_not_found', 'Data peserta kkn tidak ditemukan');
        }
        return view('pages.staff.kkn-mahasiswa.list-peserta', compact('kkn', 'mahasiswaList'));
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

    public function deleteKelompok(string $nama, string $periode, string $id)
    {
        try {
            $kkn = KknModel::where('nama', $nama)
                ->whereHas('periode', function ($query) use ($periode) {
                    $query->where('nama', $periode);
                })
                ->firstOrFail();

            $kelompok = KelompokModel::findOrFail($id);

            // Update kkn_mahasiswas table to disassociate mahasiswa from kelompok
            $kkn->kknMahasiswas()
                ->where('kelompok_id', $id)
                ->update(['kelompok_id' => null]);

            // Delete the Kelompok
            $kelompok->delete();

            return redirect()->back()->with('success_message_delete', 'Kelompok berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->back()->with('error_message_not_found', 'Data kelompok tidak ditemukan');
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error_message', 'An error occurred: ' . $e->getMessage());
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