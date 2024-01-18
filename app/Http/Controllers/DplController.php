<?php

namespace App\Http\Controllers;

use App\Models\DplModel;
use App\Models\FakultasModel;
use App\Models\ProdiModel;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class DplController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dpl = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->where('roles.role_name', '=', 'Dosen')
        ->select('users.*', 'roles.role_name')
        ->get();
        $totalDpl = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->where('roles.role_name', '=', 'Dosen')
        ->select('users.*', 'roles.role_name')
        ->count();
        $newDpl = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->join('dpls', 'users.user_id', '=', 'dpls.user_id')
        ->where('roles.role_name', '=', 'Dosen')
        ->select('dpls.nama')
        ->orderBy('users.created_at', 'desc')
        ->pluck('nama')
        ->first();
        $newDplThisMonth = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->join('dpls', 'users.user_id', '=', 'dpls.user_id')
        ->where('roles.role_name', '=', 'Dosen')
        ->select('users.*', 'roles.role_name')
        ->whereYear('users.created_at', now()->year)
        ->whereMonth('users.created_at', now()->month)
        ->count();
        return view('pages.admin.dpl.index', compact('dpl', 'totalDpl', 'newDpl', 'newDplThisMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodiWithFakultas = FakultasModel::with('prodis')->get();
        return view('pages.admin.dpl.create', compact('prodiWithFakultas'));
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
            'nidn' => 'required|numeric',
            'telp' => 'required|numeric',
            'jenis_kelamin' => 'required',
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
            'nidn.required' => 'NIDN harus diisi!!!',
            'nidn.numeric' => 'NIDN tidak sesuai format (harus berupa angka)!!!',
            'telp.required' => 'Nomor Telephon harus diisi!!!',
            'telp.numeric' => 'Nomor Telephon tidak sesuai format (harus berupa angka)!!!',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi!!!',
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
                $imagePath = 'store/user/photo/dpl/' . $imageName;
                // upload image
                Image::make($img_tmp)->save(public_path($imagePath));
            }
        } else {
            // Set the default image path
            $imageName = 'profile-staff.png';
            // Copy the default image from store/user/input to store/user/photo
            $defaultImagePath = public_path('store/user/input/' . $imageName);
            $newImagePath = public_path('store/user/photo/dpl/' . $imageName);
            copy($defaultImagePath, $newImagePath);
        }

        $data = $request->all();
        try {
            $userId = Uuid::uuid4()->toString();
            $user = new User();
            $user->user_id = $userId;
            $user->role_id = "fe8090d9-26f5-4411-824e-29208354b238";
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

             $dpl = new DplModel();
             $dpl->dpl_id = Uuid::uuid4()->toString();
             $dpl->user_id = $userId;
             $dpl->prodi_id = $data['prodi_id'];
             $dpl->nama = $data['nama'];
             $dpl->nidn = $data['nidn'];
             $dpl->jenis_kelamin = $data['jenis_kelamin'];
             $dpl->alamat = $data['alamat'];
             $dpl->telp = $data['telp'];
             if (isset($imageName)) {
                 $dpl->foto = $imageName;
             }
             $dpl->save();

            Session::flash('success_message_create', 'Data dosen pembimbing lapangan berhasil disimpan');
            return redirect()->route('dpl.index');
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
            $dpl = User::where('user_id', $id)
                ->firstOrFail();
            $prodiWithFakultas = FakultasModel::with('prodis')->get();
                // dd($admin->toArray());
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('dpl.index')->with('error_message_not_found', 'Data dosen pembimbing tidak ditemukan');
        }
        return view('pages.admin.dpl.edit', compact('dpl', 'prodiWithFakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::where('user_id', $id)->firstOrFail();
            $dpl = DplModel::where('user_id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('dpl.index')->with('error_message_not_found', 'Data dosen pembimbing tidak ditemukan');
        }

        $data = $request->all();

        $rules = [
            'email' => 'required|email',
            'prodi_id' => 'required|exists:prodis,prodi_id',
            'nama' => 'required',
            'nidn' => 'required|numeric',
            'telp' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif',
        ];

        $customMessages = [
            'email.required' => 'Email harus diisi!!!',
            'email.email' => 'Email tidak sesuai format!!!',
            'prodi_id.required' => 'Silakan pilih program studi.',
            'prodi_id.exists' => 'Program studi yang dipilih tidak ada.',
            'nama.required' => 'Nama dosen pembimbing harus diisi!!!',
            'nidn.required' => 'NIDN harus diisi!!!',
            'nidn.numeric' => 'NIDN tidak sesuai format (harus berupa angka)!!!',
            'telp.required' => 'Nomor Telephon harus diisi!!!',
            'telp.numeric' => 'Nomor Telephon tidak sesuai format (harus berupa angka)!!!',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi!!!',
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
                $imagePath = 'store/user/photo/dpl/' . $imageName;
                // Upload image
                Image::make($img_tmp)->save(public_path($imagePath));

                // Delete old image if it exists
                if ($dpl->foto && File::exists('store/user/photo/dpl/' . $dpl->foto)) {
                    File::delete('store/user/photo/dpl/' . $dpl->foto);
                }

                // Save the new image name to the database
                $dpl->foto = $imageName;
            }
        }

        try {
            $user->email = $data['email'];
            if (!empty($data['password'])) {
                $user->password = bcrypt($data['password']);
            }

            $dpl->prodi_id = $data['prodi_id'];
            $dpl->nama = $data['nama'];
            $dpl->nidn = $data['nidn'];
            $dpl->jenis_kelamin = $data['jenis_kelamin'];
            $dpl->alamat = $data['alamat'];
            $dpl->telp = $data['telp'];

            // Hanya simpan jika ada perubahan pada model
            if ($user->isDirty() || $dpl->isDirty()) {
                $user->save();
                $dpl->save();
            }

            Session::flash('success_message_update', 'Data dosen pembimbing berhasil diperbarui');
            return redirect()->route('dpl.index');
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
            $dpl = DplModel::where('user_id', $id)->firstOrFail();

            // Hapus foto jika ada
            if ($dpl->foto && File::exists('store/user/photo/dpl/' . $dpl->foto)) {
                File::delete('store/user/photo/dpl/' . $dpl->foto);
            }

            $dpl->delete();
            $user->delete();

            Session::flash('success_message_delete', 'Data dosen pembimbing berhasil dihapus');
            return redirect()->route('dpl.index');
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('dpl.index')->with('error_message_not_found', 'Data dosen pembimbing tidak ditemukan');
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return redirect()->route('dpl.index')->with('error_message_delete', 'Gagal menghapus data dosen pembimbing');
        }
    }
}
