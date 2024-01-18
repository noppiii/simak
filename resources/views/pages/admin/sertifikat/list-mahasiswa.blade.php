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
            <div class="col-lg-12 mb-12 col-md-12">
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
                        <form action="{{ route('list.sesertifikat.mahasiswa', ['nama' => request()->route('nama'), 'periode' => request()->route('periode')]) }}" method="GET">
                            <div class="card-body demo-vertical-spacing demo-only-element">
                                <div class="row mb-2">
                                    <div class="col-md-10">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Cari data KKN..."
                                                aria-label="Cari data KKN..."
                                                aria-describedby="basic-addon-search31"
                                                name="searchkKn"
                                                value="{{ $search }}"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button type="submit" class="btn btn-primary mx-1">
                                            <span class="ti ti-search me-1"></span>Cari
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    @foreach ($prodi as $data)
                                    @php
                                    $urlParams = [
                                        'prodi' => $data->nama,
                                        'searchkKn' => $search,
                                    ];

                                    if (!$search) {
                                        unset($urlParams['searchkKn']);
                                    }

                                    // Pass the $urlParams as separate parameters, not as an array
                                    $url = route('list.sesertifikat.mahasiswa', array_merge(['nama' => request()->route('nama'), 'periode' => request()->route('periode')], $urlParams));

                                    $isActive = ($selectedProdi == $data->nama);
                                @endphp

                                        <a href="{{ $url }}" class="btn btn-{{ $isActive ? 'primary' : 'light' }} mx-1">
                                            <span class="ti ti-category-2 me-1"></span>{{ $data->nama }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card card-action mb-4">
                    <div class="card-header align-items-center text-center">
                        <h5 class="card-action-title mb-0">Daftar Mahasiswa</h5>
                    </div>
                    <div class="card-body">
                      <div class="added-cards">
                        @if(count($mahasiswaList) > 0)
                        @foreach ($mahasiswaList as $data)
                        <div class="cardMaster border p-3 rounded mb-3">
                          <div class="d-flex justify-content-between flex-sm-row flex-column">
                            <div class="card-information">
                              <img
                                class="avatar avatar-lg pull-up"
                                src="{{ asset('store/user/photo/mahasiswa/' .   $data->foto) }}"
                                alt="Master Card"
                              />
                              <p class="mb-2 pt-1"> <span class="fw-bold">Nama : </span> {{ $data->nama }}</p>
                              <span class="card-number"
                                > <span class="fw-bold">NIM : </span> {{ $data->nim }}</span
                              >
                            </div>
                            <div class="d-flex flex-column text-start text-lg-end">
                                <div class="d-flex order-sm-0 order-1 mt-3 ms-auto">
                                    @if ($data->kknMahasiswa->sertifikatKkn == null)
                                    <a href="{{ route('create.sertifikat.mhs',  ['nama' => request()->route('nama'), 'periode' => request()->route('periode'), 'nim' =>$data->nim]) }}"class="btn btn-label-primary me-3">
                                        <i class="ti ti-certificate me-1"></i> Create
                                    </a>
                                    <div class="btn btn-label-danger me-3">
                                        <i class="ti ti-alert-triangle me-1"></i> Sertifikat Belum Tersedia
                                    </div>
                                    @else
                                        <a target="_blank" href="{{ route('list.berkas.berkas',  ['nama' => request()->route('nama'), 'periode' => request()->route('periode'), 'nim' =>$data->nim]) }}"class="btn btn-label-warning me-3">
                                            <i class="ti ti-pencil me-1"></i> Edit
                                        </a>
                                        <a target="_blank" href="{{ route('list.berkas.berkas',  ['nama' => request()->route('nama'), 'periode' => request()->route('periode'), 'nim' =>$data->nim]) }}"class="btn btn-label-success me-3">
                                            <i class="ti ti-certificate me-1"></i> Sertifikat
                                        </a>
                                    @endif
                                </div>
                                <small class="mt-sm-auto mt-2 order-sm-1 order-0">
                                    <span class="fw-bold">Program Studi : </span> {{ $data->prodi->nama }}
                                </small>
                                <small class="mt-sm-auto mt-2 order-sm-1 order-0">
                                    <span class="fw-bold">Fakultas : </span> {{ $data->prodi->fakultas->nama }}
                                </small>
                            </div>
                          </div>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center">
                            <img src="{{ asset('image/data-not-found.png') }}" alt="No Data Image" class="img-fluid w-40" />
                        </div>
                        @endif
                      </div>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <!-- Tombol Previous -->
                            @if ($mahasiswaList->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $mahasiswaList->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            @endif

                            <!-- Tombol Halaman -->
                            @foreach ($mahasiswaList->getUrlRange(1, $mahasiswaList->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $mahasiswaList->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <!-- Tombol Next -->
                            @if ($mahasiswaList->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $mahasiswaList->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                  </div>
              <!--/ Teams Cards -->
             </div>
  </div>
@endsection
