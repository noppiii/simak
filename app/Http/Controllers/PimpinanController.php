<?php

namespace App\Http\Controllers;

use App\Models\PimpinanModel;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class PimpinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pimpinan = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->where('roles.role_name', '=', 'Pimpinan')
        ->select('users.*', 'roles.role_name')
        ->get();
        $totalPimpinan = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->where('roles.role_name', '=', 'Pimpinan')
        ->select('users.*', 'roles.role_name')
        ->count();
        $newPimpinan = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->join('pimpinans', 'users.user_id', '=', 'pimpinans.user_id')
        ->where('roles.role_name', '=', 'Pimpinan')
        ->select('pimpinans.nama')
        ->orderBy('users.created_at', 'desc')
        ->pluck('nama')
        ->first();
        $newPimpinanThisMonth = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->join('pimpinans', 'users.user_id', '=', 'pimpinans.user_id') // Adjust the join condition based on your relationship
        ->where('roles.role_name', '=', 'Pimpinan')
        ->select('users.*', 'roles.role_name')
        ->whereYear('users.created_at', now()->year)
        ->whereMonth('users.created_at', now()->month)
        ->count();
        return view('pages.admin.pimpinan.index', compact('pimpinan', 'totalPimpinan', 'newPimpinan', 'newPimpinanThisMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.pimpinan.create');
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
            'nama' => 'required',
            'telp' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif',
        ];

        $customMessages = [
            'email.required' => 'Email harus diisi!!!',
            'email.email' => 'Email tidak sesuai format!!!',
            'password.required' => 'Password harus diisi!!!',
            'nama.required' => 'Nama dosen pembimbing harus diisi!!!',
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
                $imagePath = 'store/user/photo/pimpinan/' . $imageName;
                // upload image
                Image::make($img_tmp)->save(public_path($imagePath));
            }
        } else {
            // Set the default image path
            $imageName = 'profile-staff.png';
            // Copy the default image from store/user/input to store/user/photo
            $defaultImagePath = public_path('store/user/input/' . $imageName);
            $newImagePath = public_path('store/user/photo/pimpinan/' . $imageName);
            copy($defaultImagePath, $newImagePath);
        }

        $data = $request->all();
        try {
            $userId = Uuid::uuid4()->toString();
            $user = new User();
            $user->user_id = $userId;
            $user->role_id = "c8466b6f-5e5b-4d73-8b92-897f9d5166dc";
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

             $pimpinan = new PimpinanModel();
             $pimpinan->pimpinan_id = Uuid::uuid4()->toString();
             $pimpinan->user_id = $userId;
             $pimpinan->nama = $data['nama'];
             $pimpinan->jenis_kelamin = $data['jenis_kelamin'];
             $pimpinan->alamat = $data['alamat'];
             $pimpinan->telp = $data['telp'];
             if (isset($imageName)) {
                 $pimpinan->foto = $imageName;
             }
             $pimpinan->save();

            Session::flash('success_message_create', 'Data pimpinan berhasil disimpan');
            return redirect()->route('pimpinan.index');
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
            $pimpinan = User::where('user_id', $id)
                ->firstOrFail();
                // dd($admin->toArray());
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('pimpinan.index')->with('error_message_not_found', 'Data pimpinan tidak ditemukan');
        }
        return view('pages.admin.pimpinan.edit', compact('pimpinan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::where('user_id', $id)->firstOrFail();
            $pimpinan = PimpinanModel::where('user_id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('pimpinan.index')->with('error_message_not_found', 'Data pimpinan tidak ditemukan');
        }

        $data = $request->all();

        $rules = [
            'email' => 'required|email',
            'nama' => 'required',
            'telp' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif',
        ];

        $customMessages = [
            'email.required' => 'Email harus diisi!!!',
            'email.email' => 'Email tidak sesuai format!!!',
            'nama.required' => 'Nama dosen pembimbing harus diisi!!!',
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
                $imagePath = 'store/user/photo/pimpinan/' . $imageName;
                // Upload image
                Image::make($img_tmp)->save(public_path($imagePath));

                // Delete old image if it exists
                if ($pimpinan->foto && File::exists('store/user/photo/pimpinan/' . $pimpinan->foto)) {
                    File::delete('store/user/photo/pimpinan/' . $pimpinan->foto);
                }

                // Save the new image name to the database
                $pimpinan->foto = $imageName;
            }
        }

        try {
            $user->email = $data['email'];
            if (!empty($data['password'])) {
                $user->password = bcrypt($data['password']);
            }
            $pimpinan->nama = $data['nama'];
            $pimpinan->jenis_kelamin = $data['jenis_kelamin'];
            $pimpinan->alamat = $data['alamat'];
            $pimpinan->telp = $data['telp'];

            // Hanya simpan jika ada perubahan pada model
            if ($user->isDirty() || $pimpinan->isDirty()) {
                $user->save();
                $pimpinan->save();
            }

            Session::flash('success_message_update', 'Data pimpinan berhasil diperbarui');
            return redirect()->route('pimpinan.index');
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
            $pimpinan = PimpinanModel::where('user_id', $id)->firstOrFail();

            // Hapus foto jika ada
            if ($pimpinan->foto && File::exists('store/user/photo/pimpinan/' . $pimpinan->foto)) {
                File::delete('store/user/photo/pimpinan/' . $pimpinan->foto);
            }

            $pimpinan->delete();
            $user->delete();

            Session::flash('success_message_delete', 'Data pimpinan berhasil dihapus');
            return redirect()->route('pimpinan.index');
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('pimpinan.index')->with('error_message_not_found', 'Data pimpinan tidak ditemukan');
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return redirect()->route('pimpinan.index')->with('error_message_delete', 'Gagal menghapus data pimpinan');
        }
    }
}