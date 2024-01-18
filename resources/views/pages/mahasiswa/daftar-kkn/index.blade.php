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
                    <h5 class="text-primary">Welcome {{ Auth::guard('authuser')->user()->mahasiswa->nama }}! 🎉</h5>
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
                                        placeholder="Cari data KKN..."
                                        aria-label="Cari data KKN..."
                                        aria-describedby="basic-addon-search31"
                                    />
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <button type="button" class="btn btn-primary mx-1">
                                    <span class="ti ti-search me-1"></span>Cari
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            @foreach ($skema as $data)
                                <button type="button" class="btn btn-sm btn-primary mx-1">
                                    <span class="ti ti-category-2 me-1"></span>{{ $data->nama }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
             <!-- Teams Cards -->
             <div class="row g-4 mb-4">
              @foreach ($kkn as $data)
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card">
                  <div class="card-header">
                    @php
                        $colors = ['primary', 'secondary', 'success', 'danger', 'warning'];
                    @endphp
                    <div class="d-flex align-items-center mb-3">
                        <a href="{{ route('daftar-kkn.show', ['nama' => $data->nama, 'periode' => $data->periode->nama]) }}" class="stretched-link d-flex align-items-center">
                            @php
                                $colors = ['primary', 'secondary', 'success', 'danger', 'warning'];
                            @endphp
                         <div class="avatar avatar-lg me-2">
                            <span class="avatar-initial rounded-circle bg-{{ $colors[array_rand($colors)] }}" data-id="initials"></span>
                        </div>
                        <div class="me-2 text-body h5 mb-0 userName">{{ $data->nama }}</div>
                        </a>
                        <div class="ms-auto">
                        </div>
                      </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap">
                      <div class="bg-lighter px-3 py-2 rounded me-auto mb-3">
                        <h6 class="mb-0 text-danger">Batas Pendaftaran</h6>
                        <span>{{ $data->tanggal_pendaftaran }}</span>
                      </div>
                      <div class="text-end mb-3">
                        <h6 class="mb-0">Mulai: <span class="text-body fw-normal">{{ $data->tanggal_mulai }}</span></h6>
                        <h6 class="mb-1">Selesai: <span class="text-body fw-normal">{{ $data->tanggal_selesai }}</span></h6>
                      </div>
                    </div>
                    <p class="mb-0">
                        {{ implode(' ', array_slice(str_word_count($data->deskripsi, 1), 0, 15)) }} <span class="fw-bold">....lihat selengkapnya</span>
                    </p>
                  </div>
                  <div class="card-body border-top">
                    <div class="d-flex align-items-center mb-3">
                      <h6 class="mb-1">Lokasi: <i class="ti ti-map-pin me-1"></i><span class="text-body fw-normal">Desa {{ $data->desa->nama }}, Kecamatan {{ $data->desa->kecamatan->nama }}, Kabupaten {{ $data->desa->kecamatan->kabupaten->nama }}</span></h6>
                      <span class="badge bg-label-success ms-auto">{{ $data->skema->nama }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1">
                      <small>Kouta: 12/90</small>
                      <small>42% Terpenuhi</small>
                    </div>
                    <div class="progress mb-2" style="height: 8px">
                      <div
                        class="progress-bar"
                        role="progressbar"
                        style="width: 42%"
                        aria-valuenow="42"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                    <div class="d-flex align-items-center pt-1">
                      <div class="d-flex align-items-center">
                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 zindex-2">
                          <li><small class="text-muted">
                            <div class="d-flex">
                                <a href="javascript:void(0)" class="me-3">
                                  <img
                                    src="../../assets/img/icons/misc/pdf.png"
                                    alt="PDF image"
                                    width="15"
                                    class="me-2"
                                  />
                                  <span class="fw-semibold text-heading">surat.pdf</span>
                                </a>
                              </div>
                        </small></li>
                        </ul>
                      </div>
                      <div class="ms-auto">
                        <button type="button" class="btn btn-sm btn-primary mx-1">
                            <span class="ti ti-arrow-narrow-right me-1"></span>Daftar
                        </button>
                      </div>
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
