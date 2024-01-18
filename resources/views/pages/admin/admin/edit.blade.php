@extends('layouts.admin.main')
@section('title')
    Admin || Admin
@endsection
@section('pages')
        Update Admin
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
              <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                  <div class="card-body">
                    <h5 class="text-primary">Tambah Admin</h5>
                    <p>Di sini anda dapat menambahkan user sebagai admin, tolong isi form dengan benar</p>
                    <button id="viewDataLink" class="btn btn-sm btn-outline-primary">View Form</button>
                  </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                  <div class="card-body pb-0 px-0 px-md-4">
                    <img
                      src="{{ asset('image/admin.jpg') }}"
                      height="150"
                      alt="View Badge User"
                      data-app-dark-img="illustrations/man-with-laptop-dark.png"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
         <!-- Multi Column with Form Separator -->
         <div class="card mb-4">
            <form class="card-body" action="{{ route('admin.update', $admin->user_id) }}" method="post" enctype="multipart/form-data">                @csrf
                @csrf
                @method('PUT')
              <h6>1. Detail Akun</h6>
              <div class="row g-3">
                <div class="row mb-3 mt-4">
                    <label class="col-sm-2 form-label" for="basic-icon-default-email">Email</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-mail"></i></span>
                        <input
                          type="text"
                          id="basic-icon-default-email"
                          class="form-control"
                          placeholder="xxxxxx@xxxx.xx"
                          aria-describedby="basic-icon-default-email2"
                          name="email"
                          value="{{ $admin->email }}"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="multicol-password">Password<small class="text-muted d-block">*Jika Ingin Mengganti Password</small></label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-key"></i></span>
                        <input
                        type="password"
                        id="multicol-password"
                        class="form-control"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="multicol-password2"
                        name="password"
                      />
                      </div>
                    </div>
                  </div>
              </div>
              <hr class="my-4 mx-n4" />
              <h6>2. Informasi Personal</h6>
              <div class="row g-3">
                <div class="row mb-3 mt-4">
                    <label class="col-sm-2 form-label" for="basic-icon-default-fullname">Nama</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="ti ti-user"></i
                        ></span>
                        <input
                          type="text"
                          class="form-control"
                          id="basic-icon-default-fullname"
                          placeholder="Masukan nama admin"
                          aria-describedby="basic-icon-default-fullname2"
                          name="nama"
                          value="{{ $admin->admin->nama }}"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Nomor Telepon</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-phone2" class="input-group-text"
                          ><i class="ti ti-phone"></i
                        ></span>
                        <input
                          type="text"
                          id="basic-icon-default-phone"
                          class="form-control phone-mask"
                          placeholder="08xxxxxxxx"
                          aria-describedby="basic-icon-default-phone2"
                          name="telp"
                          value="{{ $admin->admin->telp }}"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Foto</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="file" class="form-control" name="foto" id="inputGroupFile02" accept="image/*" />
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                        </div>
                        @if ($admin->admin->foto)
                        <div class="avatar avatar-xl mt-2">
                            <img src="{{ asset('store/user/photo/admin/' . $admin->admin->foto) }}" alt="Avatar" class="rounded-circle" />
                          </div>
                         @else
                             <p>Profile Tidak Ditemukan</p>
                         @endif
                    </div>
                  </div>
              </div>
              <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                <button type="reset" class="btn btn-label-secondary">Cancel</button>
              </div>
            </form>
          </div>
    </div>
  </div>


@endsection
