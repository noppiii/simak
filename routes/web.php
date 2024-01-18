<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AnggotaKelompokController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\DaftarMahasiswaKknController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\DosenDashboardController;
use App\Http\Controllers\DplController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KknController;
use App\Http\Controllers\KknMahasiswaController;
use App\Http\Controllers\LuaranKknController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\PenilaianDosenController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\PersyaratanController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\PimpinanDashboardController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\SertifikatMahasiswaController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\StaffAnggotaKelompokController;
use App\Http\Controllers\StaffBerkasController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\StaffDesaController;
use App\Http\Controllers\StaffKabupatenController;
use App\Http\Controllers\StaffKecamatanController;
use App\Http\Controllers\StaffKknController;
use App\Http\Controllers\StaffKknMahasiswaController;
use App\Http\Controllers\StaffPeriodeController;
use App\Http\Controllers\StaffPersyaratanController;
use App\Http\Controllers\StaffSkemaController;
use App\Http\Controllers\UtilsController;
use App\Models\KknMahasiswaModel;
use App\Models\SkemaModel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthUserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthUserController::class, 'login'])->name('login');


Route::middleware(['authuser', 'admin'])->group(function () {
    Route::prefix('admin')
    ->group(function () {
        Route::get('logout', [AuthUserController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard-pendaftaran', [AdminDashboardController::class, 'index'])->name('admin-dashboard-pendaftaran');
        Route::get('/dashboard-berkas', [AdminDashboardController::class, 'berkas'])->name('admin-dashboard-berkas');
        Route::get('/dashboard-penilaian', [AdminDashboardController::class, 'penilaian'])->name('admin-dashboard-penilaian');
        Route::resource('admin', AdminController::class);
        Route::resource('staff', StaffController::class);
        Route::resource('pimpinan', PimpinanController::class);
        Route::resource('dpl', DplController::class);
        Route::resource('mahasiswa', MahasiswaController::class);
        Route::resource('fakultas', FakultasController::class);
        Route::resource('program-studi', ProgramStudiController::class);
        Route::resource('wilayah-desa', DesaController::class);
        Route::resource('wilayah-kecamatan', KecamatanController::class);
        Route::resource('wilayah-kabupaten', KabupatenController::class);
        Route::resource('penataan-periode', PeriodeController::class);
        Route::resource('penataan-skema', SkemaController::class);
        Route::resource('penataan-persyaratan', PersyaratanController::class);
        Route::resource('kkn', KknController::class);
        Route::get('/list-kkn', [KknMahasiswaController::class, 'index'])->name('list.kkn.mhs');
        Route::get('/list-kkn/{nama} {periode}/list-kelompok', [KknMahasiswaController::class, 'kelompok'])->name('list.kkn.kelompok');
        Route::delete('/list-kkn/{nama} {periode}/list-kelompok/delete/{kelompok_id}', [KknMahasiswaController::class, 'deleteKelompok'])->name('delete.kelompok');
        Route::get('/list-kkn/{nama} {periode}/list-perserta', [KknMahasiswaController::class, 'allPeserta'])->name('list.kkn.peserta');
       // ======================= get api data =============================
        Route::get('/get-peserta-data/{nama} {periode}', [KknMahasiswaController::class, 'getPesertaData'])->name('get.peserta.data');
        Route::get('/get-prodi-data/{nama} {periode}', [KknMahasiswaController::class, 'getProdiData'])->name('get.prodi.data');
        // =================================================================
        Route::post('/generate-kelompok/{kknId}', [KknMahasiswaController::class, 'generateKelompok'])->name('generate.kelompok');
        Route::get('/list-kkn/{nama} {periode}/{kelompok_id}/anggota', [AnggotaKelompokController::class, 'index'])->name('list.anggota.kelompok');
        Route::delete('/list-kkn/{nama} {periode}/{kelompok_id}/anggota/delete/{mahasiswa_id}', [AnggotaKelompokController::class, 'deleteAnggota'])
        ->name('delete.anggota.kelompok');
        Route::get('/list-kkn/{nama} {periode}/{kelompok_id}/anggota/create', [AnggotaKelompokController::class, 'create'])->name('create.anggota.kelompok');
        Route::post('/list-kkn/{nama} {periode}/{kelompok_id}/anggota/create', [AnggotaKelompokController::class, 'store'])
        ->name('create.anggota.kelompok');
        Route::put('/list-kkn/{nama} {periode}/{kelompok_id}/anggota', [AnggotaKelompokController::class, 'editDpl'])
        ->name('edit.dpl.kelompok');
        // ============================ Berkas ============================
        Route::get('/list-berkas', [BerkasController::class, 'index'])->name('list.berkas.kkn');
        Route::get('/list-berkas/{nama} {periode}/list-mahasiswa', [BerkasController::class, 'mahasiswa'])->name('list.berkas.mahasiswa');
        Route::get('/list-berkas/{nama} {periode}/{nim}/berkas', [BerkasController::class, 'berkas'])->name('list.berkas.berkas');
        Route::put('/list-berkas/{nama} {periode}/{nim}/berkas/{berkas_id}/edit', [BerkasController::class, 'editStatusBerkas'])
        ->name('edit.status.berkas');
        // ============================ Sertifikat ===========================
        Route::get('/list-sertifikat-mahasiswa', [SertifikatController::class, 'index'])->name('list.sertifikat.kkn');
        Route::get('/list-sertifikat-mahasiswa/{nama} {periode}/list-mahasiswa', [SertifikatController::class, 'mahasiswa'])->name('list.sesertifikat.mahasiswa');
        Route::get('/list-sertifikat-mahasiswa/{nama} {periode}/{nim}/create', [SertifikatController::class, 'create'])->name('create.sertifikat.mhs');
        Route::post('/list-sertifikat-mahasiswa/{nama} {periode}/{nim}/create', [SertifikatController::class, 'process'])->name('generate.sertifikat.mhs');
    });
});

Route::middleware(['authuser', 'pimpinan'])->group(function () {
    Route::prefix('pimpinan')
    ->group(function () {
        Route::get('logout', [AuthUserController::class, 'logout'])->name('pimpinan.logout');
        Route::get('/dashboard-pendaftaran', [PimpinanDashboardController::class, 'index'])->name('pimpinan-dashboard-pendaftaran');
        Route::get('/dashboard-berkas', [PimpinanDashboardController::class, 'berkas'])->name('pimpinan-dashboard-berkas');
        Route::get('/dashboard-penilaian', [PimpinanDashboardController::class, 'penilaian'])->name('pimpinan-dashboard-penilaian');
    });
});

Route::middleware(['authuser', 'staff'])->group(function () {
    Route::prefix('staff')
    ->group(function () {
        Route::get('logout', [AuthUserController::class, 'logout'])->name('staff.logout');
        Route::get('/dashboard-pendaftaran', [StaffDashboardController::class, 'index'])->name('staff-dashboard-pendaftaran');
        Route::get('/dashboard-berkas', [StaffDashboardController::class, 'berkas'])->name('staff-dashboard-berkas');
        Route::get('/dashboard-penilaian', [StaffDashboardController::class, 'penilaian'])->name('staff-dashboard-penilaian');
        Route::resource('daerah-desa', StaffDesaController::class);
        Route::resource('daerah-kecamatan', StaffKecamatanController::class);
        Route::resource('daerah-kabupaten', StaffKabupatenController::class);
        Route::resource('pengaturan-periode', StaffPeriodeController::class);
        Route::resource('pengaturan-skema', StaffSkemaController::class);
        Route::resource('pengaturan-persyaratan', StaffPersyaratanController::class);
        Route::resource('kuliah-kerja-nyata', StaffKknController::class);
        Route::get('/list-kkn', [StaffKknMahasiswaController::class, 'index'])->name('staff.list.kkn.mhs');
        Route::get('/list-kkn/{nama} {periode}/list-kelompok', [StaffKknMahasiswaController::class, 'kelompok'])->name('staff.list.kkn.kelompok');
        Route::delete('/list-kkn/{nama} {periode}/list-kelompok/delete/{kelompok_id}', [StaffKknMahasiswaController::class, 'deleteKelompok'])->name('staff.delete.kelompok');
        Route::get('/list-kkn/{nama} {periode}/list-perserta', [StaffKknMahasiswaController::class, 'allPeserta'])->name('staff.list.kkn.peserta');
       // ======================= get api data =============================
        Route::get('/get-peserta-data/{nama} {periode}', [StaffKknMahasiswaController::class, 'getPesertaData'])->name('staff.get.peserta.data');
        Route::get('/get-prodi-data/{nama} {periode}', [StaffKknMahasiswaController::class, 'getProdiData'])->name('staff.get.prodi.data');
        // =================================================================
        Route::post('/generate-kelompok/{kknId}', [StaffKknMahasiswaController::class, 'generateKelompok'])->name('staff.generate.kelompok');
        Route::get('/list-kkn/{nama} {periode}/{kelompok_id}/anggota', [StaffAnggotaKelompokController::class, 'index'])->name('staff.list.anggota.kelompok');
        Route::delete('/list-kkn/{nama} {periode}/{kelompok_id}/anggota/delete/{mahasiswa_id}', [StaffAnggotaKelompokController::class, 'deleteAnggota'])
        ->name('staff.delete.anggota.kelompok');
        Route::get('/list-kkn/{nama} {periode}/{kelompok_id}/anggota/create', [StaffAnggotaKelompokController::class, 'create'])->name('staff.create.anggota.kelompok');
        Route::post('/list-kkn/{nama} {periode}/{kelompok_id}/anggota/create', [StaffAnggotaKelompokController::class, 'store'])
        ->name('staff.create.anggota.kelompok');
        Route::put('/list-kkn/{nama} {periode}/{kelompok_id}/anggota', [StaffAnggotaKelompokController::class, 'editDpl'])
        ->name('staff.edit.dpl.kelompok');
        Route::get('/list-berkas', [StaffBerkasController::class, 'index'])->name('staff.list.berkas.kkn');
        Route::get('/list-berkas/{nama} {periode}/list-mahasiswa', [StaffBerkasController::class, 'mahasiswa'])->name('staff.list.berkas.mahasiswa');
        Route::get('/list-berkas/{nama} {periode}/{nim}/berkas', [StaffBerkasController::class, 'berkas'])->name('staff.list.berkas.berkas');
        Route::put('/list-berkas/{nama} {periode}/{nim}/berkas/{berkas_id}/edit', [StaffBerkasController::class, 'editStatusBerkas'])
        ->name('staff.edit.status.berkas');
    });
});

Route::middleware(['authuser', 'dosen'])->group(function () {
    Route::prefix('dosen')
    ->group(function () {
        Route::get('logout', [AuthUserController::class, 'logout'])->name('dosen.logout');
        Route::get('/dashboard-penilaian', [DosenDashboardController::class, 'index'])->name('dosen-dashboard-penilaian');
        Route::get('/dashboard-peserta', [DosenDashboardController::class, 'peserta'])->name('dosen-dashboard-peserta');
        Route::get('/list-kkn', [PenilaianDosenController::class, 'index'])->name('dosen.list.kkn.mhs');
        Route::get('/list-kkn/{nama} {periode}/list-kelompok', [PenilaianDosenController::class, 'kelompok'])->name('dosen.list.kkn.kelompok');
        Route::get('/list-kkn/{nama} {periode}/{kelompok_id}/anggota', [PenilaianDosenController::class, 'allPeserta'])->name('dosen.list.anggota.kelompok');
    });
});
Route::middleware(['authuser', 'mahasiswa'])->group(function () {
    Route::prefix('mahasiswa')
    ->group(function () {
        Route::get('logout', [AuthUserController::class, 'logout'])->name('mahasiswa.logout');
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('mahasiswa-dashboard');
        Route::resource('daftar-kkn', DaftarMahasiswaKknController::class);
        Route::get('daftar/kkn/{nama} {periode}', [DaftarMahasiswaKknController::class, 'show'])->name('daftar-kkn.show');
        Route::resource('luaran', LuaranKknController::class);
        Route::resource('sertifikat-mahasiswa', SertifikatMahasiswaController::class);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';