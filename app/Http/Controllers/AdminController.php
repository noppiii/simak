<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->where('roles.role_name', '=', 'Admin')
        ->select('users.*', 'roles.role_name')
        ->get();
        $totalAdmin = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->where('roles.role_name', '=', 'Admin')
        ->select('users.*', 'roles.role_name')
        ->count();
        $newAdmin = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->join('admins', 'users.user_id', '=', 'admins.user_id')
        ->where('roles.role_name', '=', 'Admin')
        ->select('admins.nama')
        ->orderBy('users.created_at', 'desc')
        ->pluck('nama')
        ->first();
        $newAdminThisMonth = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->join('admins', 'users.user_id', '=', 'admins.user_id') // Adjust the join condition based on your relationship
        ->where('roles.role_name', '=', 'Admin')
        ->select('users.*', 'roles.role_name')
        ->whereYear('users.created_at', now()->year)
        ->whereMonth('users.created_at', now()->month)
        ->count();

        // dd($totalAdmin);
        return view('pages.admin.admin.index', compact('admin', 'totalAdmin', 'newAdmin', 'newAdminThisMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.admin.create');
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
            'foto' => 'image|mimes:jpeg,png,jpg,gif',
        ];

        $customMessages = [
            'email.required' => 'Email harus diisi!!!',
            'email.email' => 'Email tidak sesuai format!!!',
            'password.required' => 'Password harus diisi!!!',
            'nama.required' => 'Nama admin harus diisi!!!',
            'telp.required' => 'Nomor Telephon harus diisi!!!',
            'telp.numeric' => 'Nomor Telephon tidak sesuai format (harus berupa angka)!!!',
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
                $imagePath = 'store/user/photo/admin/' . $imageName;
                // upload image
                Image::make($img_tmp)->save(public_path($imagePath));
            }
        } else {
            // Set the default image path
            $imageName = 'profile-admin.png';
            // Copy the default image from store/user/input to store/user/photo
            $defaultImagePath = public_path('store/user/input/' . $imageName);
            $newImagePath = public_path('store/user/photo/admin/' . $imageName);
            copy($defaultImagePath, $newImagePath);
        }

        $data = $request->all();
        try {
            $userId = Uuid::uuid4()->toString();
            $user = new User();
            $user->user_id = $userId;
            $user->role_id = "5c7d5916-aaa6-4d9b-a90b-95e923e8eccb";
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

             $admin = new AdminModel();
             $admin->admin_id = Uuid::uuid4()->toString();
             $admin->user_id = $userId;
             $admin->nama = $data['nama'];
             $admin->telp = $data['telp'];
             if (isset($imageName)) {
                 $admin->foto = $imageName;
             }
             $admin->save();

            Session::flash('success_message_create', 'Data admin berhasil disimpan');
            return redirect()->route('admin.index');
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
            $admin = User::where('user_id', $id)
                ->firstOrFail();
                // dd($admin->toArray());
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('admin.index')->with('error_message_not_found', 'Data Admin tidak ditemukan');
        }
        return view('pages.admin.admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    try {
        $user = User::where('user_id', $id)->firstOrFail();
        $admin = AdminModel::where('user_id', $id)->firstOrFail();
    } catch (ModelNotFoundException $e) {
        // Handle not found exception
        return redirect()->route('admin.index')->with('error_message_not_found', 'Data Admin tidak ditemukan');
    }

    $data = $request->all();

    $rules = [
        'email' => 'required|email',
        'nama' => 'required',
        'telp' => 'required|numeric',
        'foto' => 'image|mimes:jpeg,png,jpg,gif',
    ];

    $customMessages = [
        'email.required' => 'Email harus diisi!!!',
        'email.email' => 'Email tidak sesuai format!!!',
        'nama.required' => 'Nama admin harus diisi!!!',
        'telp.required' => 'Nomor Telephon harus diisi!!!',
        'telp.numeric' => 'Nomor Telephon tidak sesuai format (harus berupa angka)!!!',
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
            $imagePath = 'store/user/photo/admin/' . $imageName;
            // Upload image
            Image::make($img_tmp)->save(public_path($imagePath));

            // Delete old image if it exists
            if ($admin->foto && File::exists('store/user/photo/admin/' . $admin->foto)) {
                File::delete('store/user/photo/admin/' . $admin->foto);
            }

            // Save the new image name to the database
            $admin->foto = $imageName;
        }
    }

    try {
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $admin->nama = $data['nama'];
        $admin->telp = $data['telp'];

        // Hanya simpan jika ada perubahan pada model
        if ($user->isDirty() || $admin->isDirty()) {
            $user->save();
            $admin->save();
        }

        Session::flash('success_message_update', 'Data admin berhasil diperbarui');
        return redirect()->route('admin.index');
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
        $admin = AdminModel::where('user_id', $id)->firstOrFail();

        // Hapus foto jika ada
        if ($admin->foto && File::exists('store/user/photo/admin/' . $admin->foto)) {
            File::delete('store/user/photo/admin/' . $admin->foto);
        }

        $admin->delete();
        $user->delete();

        Session::flash('success_message_delete', 'Data admin berhasil dihapus');
        return redirect()->route('admin.index');
    } catch (ModelNotFoundException $e) {
        // Handle not found exception
        return redirect()->route('admin.index')->with('error_message_not_found', 'Data Admin tidak ditemukan');
    } catch (\Exception $e) {
        // Handle other exceptions if needed
        return redirect()->route('admin.index')->with('error_message_delete', 'Gagal menghapus data Admin');
    }
}
}
