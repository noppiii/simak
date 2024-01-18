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
                    <h5 class="text-primary">Welcome {{ Auth::guard('authuser')->user()->dpl->nama }}! 🎉</h5>
                    <p>Di sini Anda dapat mengontrol dan mengelola semua aspek dosen pembimbing lapangan</p>
                    <button id="viewDataLink" class="btn btn-sm btn-outline-primary">View Data</button>
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
            <!-- Statistics -->
            <div class="col-lg-12 mb-4 col-md-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Statistics</h5>
                    <small class="text-muted">Updated 1 month ago</small>
                  </div>
                  <div class="card-body pt-2">
                    <div class="row gy-3">
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="badge rounded-pill bg-label-primary me-3 p-2">
                            <i class="ti ti-chart-pie-2 ti-sm"></i>
                          </div>
                          <div class="card-info">
                            <h5 class="mb-0">230k</h5>
                            <small>Sales</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="badge rounded-pill bg-label-info me-3 p-2">
                            <i class="ti ti-users ti-sm"></i>
                          </div>
                          <div class="card-info">
                            <h5 class="mb-0">8.549k</h5>
                            <small>Customers</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="badge rounded-pill bg-label-danger me-3 p-2">
                            <i class="ti ti-shopping-cart ti-sm"></i>
                          </div>
                          <div class="card-info">
                            <h5 class="mb-0">1.423k</h5>
                            <small>Products</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="badge rounded-pill bg-label-success me-3 p-2">
                            <i class="ti ti-currency-dollar ti-sm"></i>
                          </div>
                          <div class="card-info">
                            <h5 class="mb-0">$9745</h5>
                            <small>Revenue</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="container-xxl flex-grow-1 container-p-y">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <div class="row mb-2">
                                <div class="col-md-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Cari kelompok..."
                                            aria-label="Cari kelompok..."
                                            aria-describedby="basic-addon-search31"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary mx-1">
                                        <span class="ti ti-search me-1"></span>Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- Teams Cards -->
                 <div class="row g-4 mb-4">
                    @foreach ($kelompokList as $data)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex justify-content-between">
                            <h6 class="fw-normal mb-2">Total {{ $data->kknMahasiswas->count() }} Peserta</h6>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                @php
                                $displayedNames = [];
                                $displayedCount = 0;
                                @endphp
                                @foreach ($data->kknMahasiswas as $kknMahasiswaData)
                                    @if ($kknMahasiswaData->mahasiswa && !in_array($kknMahasiswaData->mahasiswa->foto, $displayedNames) &&  $displayedCount < 4)
                                        <li data-bs-toggle="tooltip"
                                            data-popup="tooltip-custom"
                                            data-bs-placement="top"
                                            title="{{ $kknMahasiswaData->mahasiswa->nama }}"
                                            class="avatar avatar-sm pull-up">
                                            <img class="rounded-circle" src="{{ asset('store/user/photo/mahasiswa/' .   $kknMahasiswaData->mahasiswa->foto) }}" alt="Avatar" />
                                        </li>
                                        @php
                                            $displayedNames[] = $kknMahasiswaData->mahasiswa->nama;
                                            $displayedCount++;
                                        @endphp
                                    @endif
                                @endforeach
                              <li class="avatar avatar-sm">
                                <span
                                  class="avatar-initial rounded-circle pull-up"
                                  data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  title="{{ $data->kknMahasiswas->count() - 4 }} more"
                                  >+{{ $data->kknMahasiswas->count() - 4 }}</span
                                >
                              </li>
                            </ul>
                          </div>
                          <div class="d-flex justify-content-between align-items-end mt-1">
                            <div class="role-heading">
                              <a href="{{ route('dosen.list.anggota.kelompok', ['nama' => $kkn->nama, 'periode' => $kkn->periode->nama, 'kelompok_id' => $data->kelompok_id ]) }}" class="h4 mb-1">{{ $data->nama }}</a>
                              <div
                                class="role-edit-modal d-block"
                                >
                                @php
                                    $displayedNames = [];
                                @endphp
                                @foreach ($data->kknMahasiswas as $kknMahasiswaData)
                                    @if ($kknMahasiswaData->dpl && !in_array($kknMahasiswaData->dpl->nama, $displayedNames))
                                        <span>
                                            @if ($kknMahasiswaData->dpl === null || $kknMahasiswaData->dpl === "")
                                            <span class="text-danger"><i class="ti ti-alert-triangle me-2"></i>Belum Ada DPL</span>
                                            @else
                                            <span class="text-base"><i class="ti ti-user me-2"></i>{{ $kknMahasiswaData->dpl->nama }}</span>
                                            @endif
                                        </span>
                                        @php
                                            $displayedNames[] = $kknMahasiswaData->dpl->nama;
                                        @endphp
                                    @endif
                                @endforeach
                                </div
                              >
                            </div>
                            <a href="{{ route('dosen.list.anggota.kelompok', ['nama' => $kkn->nama, 'periode' => $kkn->periode->nama, 'kelompok_id' => $data->kelompok_id ]) }}"  data-bs-toggle="modal" class="text-muted"><i class="ti ti-arrow-narrow-right ti-md text-primary"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                 </div>
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                  <li class="page-item prev">
                    <a class="page-link" href="javascript:void(0);"
                      ><i class="ti ti-chevrons-left ti-xs"></i
                    ></a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0);">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0);">2</a>
                  </li>
                  <li class="page-item active">
                    <a class="page-link" href="javascript:void(0);">3</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0);">4</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0);">5</a>
                  </li>
                  <li class="page-item next">
                    <a class="page-link" href="javascript:void(0);"
                      ><i class="ti ti-chevrons-right ti-xs"></i
                    ></a>
                  </li>
                </ul>
              </nav>
              <!--/ Teams Cards -->
             </div>
  </div>
@endsection
