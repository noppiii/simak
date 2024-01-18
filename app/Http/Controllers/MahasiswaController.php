<?php

namespace App\Http\Controllers;

use App\Models\FakultasModel;
use App\Models\MahasiswaModel;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->where('roles.role_name', '=', 'Mahasiswa')
        ->select('users.*', 'roles.role_name')
        ->get();
        $totalMahasiswa = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->where('roles.role_name', '=', 'Mahasiswa')
        ->select('users.*', 'roles.role_name')
        ->count();
        $totalMahasiswaKkn = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->join('mahasiswas', 'users.user_id', '=', 'mahasiswas.user_id')
        ->join('kkn_mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'kkn_mahasiswas.mahasiswa_id')
        ->where('roles.role_name', '=', 'Mahasiswa')
        ->count();
        $totalMahasiswaBaruKkn = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->join('mahasiswas', 'users.user_id', '=', 'mahasiswas.user_id')
        ->join('kkn_mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'kkn_mahasiswas.mahasiswa_id')
        ->where('roles.role_name', '=', 'Mahasiswa')
        ->where(DB::raw('DATEDIFF(CURRENT_TIMESTAMP, kkn_mahasiswas.created_at)'), '<=', 90)
        ->count();
        $mahasiswaDaftarKkn = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->join('mahasiswas', 'users.user_id', '=', 'mahasiswas.user_id')
        ->join('kkn_mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'kkn_mahasiswas.mahasiswa_id')
        ->where('roles.role_name', '=', 'Mahasiswa')
        ->orderBy('kkn_mahasiswas.created_at', 'desc')
        ->pluck('mahasiswas.nama')
        ->first();
        // dd($mahasiswaDaftarKkn);
        return view('pages.admin.mahasiswa.index', compact('mahasiswa', 'totalMahasiswa', 'totalMahasiswaKkn', 'totalMahasiswaBaruKkn', 'mahasiswaDaftarKkn'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodiWithFakultas = FakultasModel::with('prodis')->get();
        return view('pages.admin.mahasiswa.create', compact('prodiWithFakultas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
            'prodi_id' => 'required|exists:prodis,prodi_id',
            'nama' => 'required',
            'nim' => 'required|numeric',
            'telp' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif',
        ];

        $customMessages = [
            'email.required' => 'Email harus diisi!!!',
            'email.email' => 'Email tidak sesuai format!!!',
            'password.required' => 'Password harus diisi!!!',
            'prodi_id.required' => 'Silakan pilih program studi.',
            'prodi_id.exists' => 'Program studi yang dipilih tidak ada.',
            'nama.required' => 'Nama dosen pembimbing harus diisi!!!',
            'nim.required' => 'NIM harus diisi!!!',
            'nim.numeric' => 'NIM tidak sesuai format (harus berupa angka)!!!',
            'telp.required' => 'Nomor Telephon harus diisi!!!',
            'telp.numeric' => 'Nomor Telephon tidak sesuai format (harus berupa angka)!!!',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi!!!',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi!!!',
            'alamat.required' => 'Alamat harus diisi!!!',
            'foto.image' => 'Foto harus berupa gambar.',
            'foto.mimes' => 'Format gambar tidak valid. Hanya diperbolehkan file dengan ekstensi jpeg, png, jpg, dan gif.',
        ];

        $this->validate($request, $rules, $customMessages);

        // upload admin profile photo
        if ($request->hasFile('foto')) {
            $img_tmp = $request->file('foto');
            if ($img_tmp->isValid()) {
                // get image extension
                $extension = $img_tmp->getClientOriginalExtension();
                // generate new image name
                $imageName = rand(111, 99999) . '.' . $extension;
                $imagePath = 'store/user/photo/mahasiswa/' . $imageName;
                // upload image
                Image::make($img_tmp)->save(public_path($imagePath));
            }
        } else {
            // Set the default image path
            $imageName = 'profile-mahasiswa.png';
            // Copy the default image from store/user/input to store/user/photo
            $defaultImagePath = public_path('store/user/input/' . $imageName);
            $newImagePath = public_path('store/user/photo/mahasiswa/' . $imageName);
            copy($defaultImagePath, $newImagePath);
        }

        $data = $request->all();
        try {
            $userId = Uuid::uuid4()->toString();
            $user = new User();
            $user->user_id = $userId;
            $user->role_id = "c288bbc3-0f3d-427f-ac9c-0488377e4a50";
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

             $mhs = new MahasiswaModel();
             $mhs->mahasiswa_id = Uuid::uuid4()->toString();
             $mhs->user_id = $userId;
             $mhs->prodi_id = $data['prodi_id'];
             $mhs->nama = $data['nama'];
             $mhs->nim = $data['nim'];
             $mhs->jenis_kelamin = $data['jenis_kelamin'];
             $mhs->tanggal_lahir = $data['tanggal_lahir'];
             $mhs->alamat = $data['alamat'];
             $mhs->telp = $data['telp'];
             if (isset($imageName)) {
                 $mhs->foto = $imageName;
             }
             $mhs->save();

            Session::flash('success_message_create', 'Data mahasiswa berhasil disimpan');
            return redirect()->route('mahasiswa.index');
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
            $mahasiswa = User::where('user_id', $id)
                ->firstOrFail();
            $prodiWithFakultas = FakultasModel::with('prodis')->get();
                // dd($mahasiswa->toArray());
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('mahasiswa.index')->with('error_message_not_found', 'Data mahasiswa tidak ditemukan');
        }
        return view('pages.admin.mahasiswa.edit', compact('mahasiswa', 'prodiWithFakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::where('user_id', $id)->firstOrFail();
            $mahasiswa = MahasiswaModel::where('user_id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('mahasiswa.index')->with('error_message_not_found', 'Data Mahasiswa tidak ditemukan');
        }

        $data = $request->all();

        $rules = [
            'email' => 'required|email',
            'prodi_id' => 'required|exists:prodis,prodi_id',
            'nama' => 'required',
            'nim' => 'required|numeric',
            'telp' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif',
        ];

        $customMessages = [
            'email.required' => 'Email harus diisi!!!',
            'email.email' => 'Email tidak sesuai format!!!',
            'prodi_id.required' => 'Silakan pilih program studi.',
            'prodi_id.exists' => 'Program studi yang dipilih tidak ada.',
            'nama.required' => 'Nama dosen pembimbing harus diisi!!!',
            'nim.required' => 'NIM harus diisi!!!',
            'nim.numeric' => 'NIM tidak sesuai format (harus berupa angka)!!!',
            'telp.required' => 'Nomor Telephon harus diisi!!!',
            'telp.numeric' => 'Nomor Telephon tidak sesuai format (harus berupa angka)!!!',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi!!!',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi!!!',
            'alamat.required' => 'Alamat harus diisi!!!',
            'foto.image' => 'Foto harus berupa gambar.',
            'foto.mimes' => 'Format gambar tidak valid. Hanya diperbolehkan file dengan ekstensi jpeg, png, jpg, dan gif.',
        ];

        if (!empty($data['password'])) {
            $rules['password'] = 'required';
            $customMessages['password.required'] = 'Password harus diisi!!!';
        }

        $this->validate($request, $rules, $customMessages);

        if ($request->hasFile('foto')) {
            $img_tmp = $request->file('foto');
            if ($img_tmp->isValid()) {
                // Get image extension
                $extension = $img_tmp->getClientOriginalExtension();
                // Generate new image name
                $imageName = rand(111, 99999) . '.' . $extension;
                $imagePath = 'store/user/photo/mahasiswa/' . $imageName;
                // Upload image
                Image::make($img_tmp)->save(public_path($imagePath));

                // Delete old image if it exists
                if ($mahasiswa->foto && File::exists('store/user/photo/mahasiswa/' . $mahasiswa->foto)) {
                    File::delete('store/user/photo/mahasiswa/' . $mahasiswa->foto);
                }

                // Save the new image name to the database
                $mahasiswa->foto = $imageName;
            }
        }

        try {
            $user->email = $data['email'];
            if (!empty($data['password'])) {
                $user->password = bcrypt($data['password']);
            }

             $mahasiswa->prodi_id = $data['prodi_id'];
             $mahasiswa->nama = $data['nama'];
             $mahasiswa->nim = $data['nim'];
             $mahasiswa->jenis_kelamin = $data['jenis_kelamin'];
             $mahasiswa->tanggal_lahir = $data['tanggal_lahir'];
             $mahasiswa->alamat = $data['alamat'];
             $mahasiswa->telp = $data['telp'];

            // Hanya simpan jika ada perubahan pada model
            if ($user->isDirty() || $mahasiswa->isDirty()) {
                $user->save();
                $mahasiswa->save();
            }

            Session::flash('success_message_update', 'Data mahasiswa berhasil diperbarui');
            return redirect()->route('mahasiswa.index');
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
            $user = User::where('user_id', $id)->firstOrFail();
            $mahasiswa = MahasiswaModel::where('user_id', $id)->firstOrFail();

            // Hapus foto jika ada
            if ($mahasiswa->foto && File::exists('store/user/photo/mahasiswa/' . $mahasiswa->foto)) {
                File::delete('store/user/photo/mahasiswa/' . $mahasiswa->foto);
            }

            $mahasiswa->delete();
            $user->delete();

            Session::flash('success_message_delete', 'Data mahasiswa berhasil dihapus');
            return redirect()->route('mahasiswa.index');
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('mahasiswa.index')->with('error_message_not_found', 'Data mahasiswa tidak ditemukan');
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return redirect()->route('mahasiswa.index')->with('error_message_delete', 'Gagal menghapus data mahasiswa');
        }
    }
}