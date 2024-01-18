@extends('layouts.admin.main')
@section('title')
    Admin || Admin
@endsection
@section('pages')
    Master Admin
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
              <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                  <div class="card-body">
                    <h5 class="text-primary">Welcome {{ Auth::guard('authuser')->user()->admin->nama }}! 🎉</h5>
                    <p>Di sini Anda dapat mengontrol dan mengelola semua aspek dosen pembimbing lapangan</p>
                    <button id="viewDataLink" class="btn btn-sm btn-outline-primary">View Data</button>
                  </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                  <div class="card-body pb-0 px-0 px-md-4">
                    <img
                      src="{{ asset('image/dosen.jpg') }}"
                      height="150"
                      alt="View Badge User"
                      data-app-dark-img="illustrations/man-with-laptop-dark.png"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
            <!-- Statistics -->
            <div class="col-lg-8 mb-4 col-md-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Statistics</h5>
                    <small class="text-muted">Updated 1 month ago</small>
                  </div>
                  <div class="card-body pt-2">
                    <div class="row gy-3">
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="badge rounded-pill bg-label-danger me-3 p-2">
                            <i class="ti ti-chart-pie-2 ti-sm"></i>
                          </div>
                          <div class="card-info">
                            <h5 class="mb-0">{{ $totalDpl }}</h5>
                            <small>Total Dpl</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-6">
                        <div class="d-flex align-items-center">
                          <div class="badge rounded-pill bg-label-primary me-3 p-2">
                            <i class="ti ti-users ti-sm"></i>
                          </div>
                          <div class="card-info">
                            <h5 class="mb-0">{{ $newDplThisMonth }}</h5>
                            <small>Dpl Baru Bulan Ini</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-5 col-6">
                        <div class="d-flex align-items-center">
                          <div class="badge rounded-pill bg-label-success me-3 p-2">
                            <i class="ti ti-shopping-cart ti-sm"></i>
                          </div>
                          <div class="card-info">
                            <h5 class="mb-0 text-success">{{ $newDpl }}</h5>
                            <small>Dpl Baru</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

                <!-- Reviews -->
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                    <div class="card h-100">
                      <div class="row h-100">
                        <div class="col-sm-5">
                          <div class="d-flex align-items-center h-100 justify-content-center mt-sm-0 mt-3">
                            <img
                              src="{{ asset('image/add-user.jpg') }}"
                              class="img-fluid mt-sm-4 mt-md-0"
                              alt="add-new-roles"
                              width="100"
                            />
                          </div>
                        </div>
                        <div class="col-sm-7">
                          <div class="card-body text-sm-end text-center ps-sm-0">
                            <a href="{{ route('dpl.create') }}"
                              class="btn btn-primary mb-2 text-nowrap add-new-role d-block"
                            >
                              + DPL
                            </a>
                            <small class="mb-0 mt-1">Tambah DPL sebagai penilai</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              <div class="container-xxl flex-grow-1 container-p-y">
                <!-- DataTable with Buttons -->
                <div class="card">
                  <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic table">
                      <thead>
                        <tr>
                          <th></th>
                          <th></th>
                          <th>ID</th>
                          <th>Nama</th>
                          <th>NIDN</th>
                          <th>Progam Studi</th>
                          <th>Fakultas</th>
                          <th>Foto</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; ?>
                        @foreach($dpl as $data)
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $data->dpl->dpl_id }}</td>
                            <td>{{ $data->dpl->nama }}</td>
                            <td>{{ $data->dpl->nidn }}</td>
                            <td>{{ $data->dpl->prodi->nama }}</td>
                            <td>{{ $data->dpl->prodi->fakultas->nama }}</td>
                            <td>
                                <div class="avatar avatar-md">
                                <img src="{{ asset('store/user/photo/dpl/' . $data->dpl->foto) }}" alt="Avatar" class="rounded-circle" />
                              </div>
                            </td>
                            <td>
                                <div class="d-inline-block">
                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end m-0">'
                                    <button data-bs-toggle="modal"
                                    data-bs-target="#viewUser{{ $data->user_id }}"
                                    class="dropdown-item"><i class="ti ti-eye me-1"></i>View
                                </button>
                                    <a href="{{ route('dpl.edit', $data->user_id) }}" class="dropdown-item"><i class="ti ti-pencil me-1"></i>Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <button  data-bs-toggle="modal"
                                    data-bs-target="#onboardHorizontalImageModal{{ $data->user_id }}"
                                    class="dropdown-item text-danger delete-record"><i class="ti ti-trash text-danger me-1"></i>Delete</button>
                                    </div>
                                    </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                  </div>
                </div>
    </div>
  </div>
  {{-- ============= SHOW DATA =============== --}}
  @foreach ($dpl as $data)
  <div class="modal fade" id="viewUser{{ $data->user_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="avatar avatar-xl m-auto">
            <img src="{{ asset('store/user/photo/dpl/' . $data->dpl->foto) }}" alt="Avatar" class="rounded-circle" />
          </div>
          <div class="text-center mb-4">
            <h3 class="mb-2">{{ $data->dpl->nama }}</h3>
            <p class="text-muted">Informasi tentang {{ $data->dpl->nama }}.</p>
          </div>
          <form id="editUserForm" class="row g-3" onsubmit="return false">
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditUserName">Nama</label>
              <input
                type="text"
                id="modalEditUserName"
                name="modalEditUserName"
                class="form-control"
                placeholder="Masukan nama dpl"
                value="{{ $data->dpl->nama }}"
              />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditUserName">NIDN</label>
              <input
                type="text"
                id="modalEditUserName"
                name="modalEditUserName"
                class="form-control"
                placeholder="Masukan nidn"
                value="{{ $data->dpl->nidn }}"
              />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditUserEmail">Email</label>
              <input
                type="text"
                id="modalEditUserEmail"
                name="modalEditUserEmail"
                class="form-control"
                placeholder="xxxxxx@xxx.xx"
                value="{{ $data->email }}"
              />
            </div>
            <div class="col-12 col-md-6 form-password-toggle">
                <label class="form-label" for="basic-default-password32">Password</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    class="form-control"
                    id="basic-default-password32"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="basic-default-password"
                    value="{{ $data->password }}"
                  />
                  <span class="input-group-text cursor-pointer" id="basic-default-password"
                    ><i class="ti ti-eye-off"></i
                  ></span>
                </div>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditUserPhone">Nomor Telepon</label>
              <div class="input-group">
                <span class="input-group-text">ID</span>
                <input
                  type="text"
                  id="modalEditUserPhone"
                  name="modalEditUserPhone"
                  class="form-control phone-number-mask"
                  placeholder="08XXXXXXXXX"
                  value="{{ $data->dpl->telp }}"
                />
              </div>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label" for="modalEditUserName">Jenis Kelamin</label>
                <input
                  type="text"
                  id="modalEditUserName"
                  name="modalEditUserName"
                  class="form-control"
                  placeholder="Masukan nama dpl"
                  value="{{ $data->dpl->jenis_kelamin }}"
                />
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label" for="modalEditUserName">Program Studi</label>
                <input
                  type="text"
                  id="modalEditUserName"
                  name="modalEditUserName"
                  class="form-control"
                  placeholder="Masukan nama program studi"
                  value="{{ $data->dpl->prodi->nama }}"
                />
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label" for="modalEditUserName">Fakultas</label>
                <input
                  type="text"
                  id="modalEditUserName"
                  name="modalEditUserName"
                  class="form-control"
                  placeholder="Masukan nama fakultas"
                  value="{{ $data->dpl->prodi->fakultas->nama }}"
                />
              </div>
            <div class="col-12">
              <label class="form-label" for="modalEditUserLanguage">Alamat</label>
                  <textarea
                    id="basic-icon-default-message"
                    class="form-control"
                    placeholder="Masukan alamat"
                    aria-label="Masukan alamat"
                    aria-describedby="basic-icon-default-message2"
                  >{{ $data->dpl->alamat }}</textarea>
            </div>
            <div class="col-12 text-center">
              <button type="reset" data-bs-dismiss="modal"
              aria-label="Close"
               class="btn btn-primary me-sm-3 me-1">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  {{-- ====================== DELETE DATA ======================== --}}
  @foreach ($dpl as $data)
  <div
  class="modal-onboarding modal fade animate__animated"
  id="onboardHorizontalImageModal{{ $data->user_id }}"
  tabindex="-1"
  aria-hidden="true"
>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content text-center">
      <div class="modal-header border-0">
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body onboarding-horizontal p-0 d-block">
        <div class="onboarding-media">
          <img
            src="{{ asset('image/delete.jpg') }}"
            alt="boy-verify-email-light"
            width="273"
            class="img-fluid"
            data-app-light-img="illustrations/boy-verify-email-light.png"
            data-app-dark-img="illustrations/boy-verify-email-dark.png"
          />
        </div>
        <div class="onboarding-content mb-0">
          <h4 class="onboarding-title text-body text-danger">Hapus {{ $data->dpl->nama }}</h4>
          <small class="onboarding-info">
            Dengan menghapus {{ $data->dpl->nama }}, user ini tidak bisa lagi melakukan penilaian.
          </small>
        </div>
      </div>
      <form method="POST" action="{{ route('dpl.destroy', $data->user_id) }}">
        @csrf
        @method('DELETE')
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-danger">Hapus</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection
