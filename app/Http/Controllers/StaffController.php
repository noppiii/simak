<?php

namespace App\Http\Controllers;

use App\Models\StaffModel;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->where('roles.role_name', '=', 'Staff')
        ->select('users.*', 'roles.role_name')
        ->get();
        $totalStaff = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->where('roles.role_name', '=', 'Staff')
        ->select('users.*', 'roles.role_name')
        ->count();
        $newStaff = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->join('staff', 'users.user_id', '=', 'staff.user_id')
        ->where('roles.role_name', '=', 'Staff')
        ->select('staff.nama')
        ->orderBy('users.created_at', 'desc')
        ->pluck('nama')
        ->first();
        $newStaffThisMonth = User::join('roles', 'users.role_id', '=', 'roles.role_id')
        ->join('staff', 'users.user_id', '=', 'staff.user_id')
        ->where('roles.role_name', '=', 'Staff')
        ->select('users.*', 'roles.role_name')
        ->whereYear('users.created_at', now()->year)
        ->whereMonth('users.created_at', now()->month)
        ->count();

        return view('pages.admin.staff.index', compact('staff', 'totalStaff', 'newStaff', 'newStaffThisMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.staff.create');
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
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg,gif',
        ];

        $customMessages = [
            'email.required' => 'Email harus diisi!!!',
            'email.email' => 'Email tidak sesuai format!!!',
            'password.required' => 'Password harus diisi!!!',
            'nama.required' => 'Nama staff harus diisi!!!',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi!!!',
            'alamat.required' => 'Alamat harus diisi!!!',
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
                $imagePath = 'store/user/photo/staff/' . $imageName;
                // upload image
                Image::make($img_tmp)->save(public_path($imagePath));
            }
        } else {
            // Set the default image path
            $imageName = 'profile-staff.png';
            // Copy the default image from store/user/input to store/user/photo
            $defaultImagePath = public_path('store/user/input/' . $imageName);
            $newImagePath = public_path('store/user/photo/staff/' . $imageName);
            copy($defaultImagePath, $newImagePath);
        }

        $data = $request->all();
        try {
            $userId = Uuid::uuid4()->toString();
            $user = new User();
            $user->user_id = $userId;
            $user->role_id = "10dff1d9-e279-4024-88fa-fcd8b0ec8f25";
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

             $staff = new StaffModel();
             $staff->staff_id = Uuid::uuid4()->toString();
             $staff->user_id = $userId;
             $staff->nama = $data['nama'];
             $staff->telp = $data['telp'];
             $staff->jenis_kelamin = $data['jenis_kelamin'];
             $staff->alamat = $data['alamat'];
             if (isset($imageName)) {
                 $staff->foto = $imageName;
             }
             $staff->save();

            Session::flash('success_message_create', 'Data staff berhasil disimpan');
            return redirect()->route('staff.index');
        } catch (QueryException $e) {
            // Handle the integrity constraint violation exception (duplicate entry)
            if ($e->getCode() === 23000) {
                // Duplicate entry error
                $errorMessage = 'Uppsss Terjadi Kesalahan. Silahkan Ulangi Lagi.';
            } else {
                // Other database-related errors
                $errorMessage = 'Uppsss Terjadi Kesalahan. Silahkan Ulangi Lagi.';
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
            $staff = User::where('user_id', $id)
                ->firstOrFail();
                // dd($admin->toArray());
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('staff.index')->with('error_message_not_found', 'Data staff tidak ditemukan');
        }
        return view('pages.admin.staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::where('user_id', $id)->firstOrFail();
            $staff = StaffModel::where('user_id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('staff.index')->with('error_message_not_found', 'Data staff tidak ditemukan');
        }

        $data = $request->all();

        $rules = [
            'email' => 'required|email',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg,gif',
        ];

        $customMessages = [
            'email.required' => 'Email harus diisi!!!',
            'email.email' => 'Email tidak sesuai format!!!',
            'nama.required' => 'Nama staff harus diisi!!!',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi!!!',
            'alamat.required' => 'Alamat harus diisi!!!',
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
                $imagePath = 'store/user/photo/staff/' . $imageName;
                // Upload image
                Image::make($img_tmp)->save(public_path($imagePath));

                // Delete old image if it exists
                if ($staff->foto && File::exists('store/user/photo/staff/' . $staff->foto)) {
                    File::delete('store/user/photo/staff/' . $staff->foto);
                }

                // Save the new image name to the database
                $staff->foto = $imageName;
            }
        }

        try {
            $user->email = $data['email'];
            if (!empty($data['password'])) {
                $user->password = bcrypt($data['password']);
            }

            $staff->nama = $data['nama'];
            $staff->telp = $data['telp'];
            $staff->jenis_kelamin = $data['jenis_kelamin'];
            $staff->alamat = $data['alamat'];

            // Hanya simpan jika ada perubahan pada model
            if ($user->isDirty() || $staff->isDirty()) {
                $user->save();
                $staff->save();
            }

            Session::flash('success_message_update', 'Data staff berhasil diperbarui');
            return redirect()->route('staff.index');
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
            $staff = StaffModel::where('user_id', $id)->firstOrFail();

            // Hapus foto jika ada
            if ($staff->foto && File::exists('store/user/photo/staff/' . $staff->foto)) {
                File::delete('store/user/photo/staff/' . $staff->foto);
            }

            $staff->delete();
            $user->delete();

            Session::flash('success_message_delete', 'Data staff berhasil dihapus');
            return redirect()->route('staff.index');
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('staff.index')->with('error_message_not_found', 'Data staff tidak ditemukan');
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return redirect()->route('staff.index')->with('error_message_delete', 'Gagal menghapus data staff');
        }
    }
}