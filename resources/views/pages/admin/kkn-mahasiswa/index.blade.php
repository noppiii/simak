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

                <!-- Reviews -->
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                    <div class="card h-100">
                      <div class="row h-100">
                        <div class="col-sm-5">
                          <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                            <img
                              src="../../assets/img/illustrations/add-new-roles.png"
                              class="img-fluid mt-sm-4 mt-md-0"
                              alt="add-new-roles"
                              width="83"
                            />
                          </div>
                        </div>
                        <div class="col-sm-7">
                          <div class="card-body text-sm-end text-center ps-sm-0">
                            <a href="{{ route('kkn.create') }}"
                              class="btn btn-primary mb-2 text-nowrap add-new-role d-block"
                            >
                              Tambah KKN
                            </a>
                            <small class="mb-0 mt-1">Tambah data KKN</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              <div class="container-xxl flex-grow-1 container-p-y">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <form action="{{ route('list.kkn.mhs') }}" method="GET">
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
                                    @foreach ($skema as $data)
                                        @php
                                            $urlParams = [
                                                'skema' => $data->nama,
                                                'searchkKn' => $search,
                                            ];
                                            if (!$search) {
                                                unset($urlParams['searchkKn']);
                                            }
                                            $url = route('list.kkn.mhs', $urlParams);
                                            $isActive = ($selectedSkema == $data->nama);
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
                 <!-- Teams Cards -->
                 <div class="row g-4 mb-4">
                    @if(count($kkn) > 0)
                    @foreach ($kkn as $data)
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <a href="{{ route('list.kkn.kelompok', ['nama' => $data->nama, 'periode' => $data->periode->nama]) }}" class="d-flex align-items-center">
                                            @php
                                                $colors = ['primary', 'secondary', 'success', 'danger', 'warning'];
                                            @endphp
                                            <div class="avatar me-2">
                                                <span class="avatar-initial rounded-circle bg-{{ $colors[array_rand($colors)] }}" data-id="initials"></span>
                                            </div>
                                            <div class="me-2 text-body h5 mb-0 userName">{{ $data->nama }}</div>
                                        </a>
                                        <div class="ms-auto">
                                        </div>
                                    </div>
                                    <div class="text-start mb-3 d-flex">
                                        <p class="mb-1"><span class="text-success fw-normal badge bg-label-success mx-1"><i class="ti ti-calendar-plus me-1"></i>{{ $data->tanggal_mulai }}</span></p>
                                        <p class="mb-1"><span class="text-danger fw-normal badge bg-label-danger mx-1"><i class="ti ti-calendar-minus"></i>{{ $data->tanggal_selesai }}</span></p>
                                    </div>
                                    <div class="text-justify">
                                        <p class="mb-1">
                                            {{ implode(' ', array_slice(str_word_count($data->deskripsi, 1), 0, 15)) }} <span class="fw-bold">....lihat selengkapnya</span>
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center pt-1">
                                        <div class="d-flex align-items-center">
                                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                                <li
                                                  data-bs-toggle="tooltip"
                                                  data-popup="tooltip-custom"
                                                  data-bs-placement="top"
                                                  title="Vinnie Mostowy"
                                                  class="avatar avatar-sm pull-up"
                                                >
                                                  <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar" />
                                                </li>
                                                <li
                                                  data-bs-toggle="tooltip"
                                                  data-popup="tooltip-custom"
                                                  data-bs-placement="top"
                                                  title="Allen Rieske"
                                                  class="avatar avatar-sm pull-up"
                                                >
                                                  <img class="rounded-circle" src="../../assets/img/avatars/12.png" alt="Avatar" />
                                                </li>
                                                <li
                                                  data-bs-toggle="tooltip"
                                                  data-popup="tooltip-custom"
                                                  data-bs-placement="top"
                                                  title="Julee Rossignol"
                                                  class="avatar avatar-sm pull-up"
                                                >
                                                  <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar" />
                                                </li>
                                                <li class="avatar avatar-sm">
                                                  <span
                                                    class="avatar-initial rounded-circle pull-up"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="8 more"
                                                    >+8</span
                                                  >
                                                </li>
                                              </ul>
                                        </div>
                                        <div class="ms-auto">
                                            <a href="javascript:;" class="me-2"><span class="badge bg-label-primary"><i class="ti ti-category-2 me-1"></i>{{ $data->skema->nama }}</span></a>
                                            <a href="javascript:;"><span class="badge bg-label-warning"><i class="ti ti-calendar-event me-1"></i>{{ $data->periode->nama }}</span></a>
                                        </div>
                                    </div>
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
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <!-- Tombol Previous -->
                    @if ($kkn->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link" aria-hidden="true">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $kkn->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @endif

                    <!-- Tombol Halaman -->
                    @foreach ($kkn->getUrlRange(1, $kkn->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $kkn->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <!-- Tombol Next -->
                    @if ($kkn->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $kkn->nextPageUrl() }}" aria-label="Next">
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
              <!--/ Teams Cards -->
             </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Mendapatkan semua elemen dengan class userName
        var userNameElements = document.querySelectorAll(".userName");

        userNameElements.forEach(function (userNameElement) {
            // Mendapatkan nama dari elemen dengan class userName
            var userName = userNameElement.textContent || userNameElement.innerText;

            // Menghasilkan inisial dua huruf dari seluruh nama (maksimal dua huruf)
            var initials = userName.match(/\b\w/g).slice(0, 2).join("").toUpperCase();

            // Menetapkan inisial ke elemen dengan class initials
            var initialsElement = userNameElement.previousElementSibling.querySelector("[data-id='initials']");
            initialsElement.textContent = initials;
        });
    });
</script>
@endsection
