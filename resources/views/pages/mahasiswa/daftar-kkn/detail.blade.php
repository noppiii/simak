@extends('layouts.admin.main')
@section('title')
    Admin || Admin
@endsection
@section('pages')
    Master Admin
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row invoice-add">
        <!-- Invoice Add-->
        <div class="col-lg-12 col-12 mb-lg-0 mb-4">
          <div class="card invoice-preview-card">
            <div class="card-body">
              <div class="row m-sm-4 m-0">
                <div class="col-md-7 mb-md-0 mb-4 ps-0">
                  <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                    <div class="avatar avatar-lg me-2">
                        @php
                            $colors = ['primary', 'secondary', 'success', 'danger', 'warning'];
                        @endphp
                        <span class="avatar-initial rounded-circle bg-{{ $colors[array_rand($colors)] }}" id="initials"></span>
                    </div>

                    <span class="app-brand-text fw-bold fs-4 text-body" id="userName"> {{ $kkn->nama }} </span>
                  </div>
                  <p class="mb-2 fs-5">
                    <span class="badge rounded-pill bg-label-primary"><i class="ti ti-category-2 me-1"></i>{{ $kkn->skema->nama }}</span>
                    <span class="badge rounded-pill bg-label-info"><i class="ti ti-calendar-event me-1"></i>{{ $kkn->periode->nama }}</span>
                </p>
                  <p class="mb-2"><i class="ti ti-map-pin me-1"></i> Desa {{ $kkn->desa->nama }}, Kecamatan {{ $kkn->desa->kecamatan->nama }}, Kabupaten {{ $kkn->desa->kecamatan->kabupaten->nama }}</p>
                  <p class="mb-2"><i class="ti ti-users me-1"></i> 80/120 Peserta</p>
                  <p class="mb-0">
                    <a href="javascript:void(0)" class="me-3">
                    <img
                      src="{{ asset('assets/img/icons/misc/pdf.png') }}"
                      alt="PDF image"
                      width="15"
                      class="me-2"
                    />
                    <a href="#" class="fw-semibold text-heading">surat.pdf</a>
                  </a>
                </p>
                </div>
                <div class="col-md-5">
                  <dl class="row mb-2">
                    <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                    </dt>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                    </dd>
                    <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                      <span class="fw-normal">Pelaksanaan:</span>
                    </dt>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                        <div class="w-px-150 badge bg-label-success">
                            {{ $kkn->tanggal_mulai }}
                        </div>
                    </dd>
                    <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end ps-0">
                      <span class="fw-normal">Selesai:</span>
                    </dt>
                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                        <div class="w-px-150 badge bg-label-danger">
                            {{ $kkn->tanggal_selesai }}
                        </div>
                    </dd>
                  </dl>
                </div>
              </div>
              <div class="row p-sm-4 p-0">
                <div class="col-md-8 col-sm-5 col-12 mb-sm-0 mb-4">
                  <h6 class="mb-2">Deskripsi:</h6>
                  <p class="mb-4">{{ $kkn->deskripsi }}</p>
                  <h6 class="mb-2">Persyaratan:</h6>
                  @foreach ($kkn->persyaratans as $persyaratan)
                    <li class="mb-1">{{ $persyaratan->nama }}</li>
                  @endforeach
                </div>
                <div class="col-md-4 col-sm-7">
                  <img
                  src="{{ asset('image/admin.jpg') }}"
                  height="150"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                />
                </div>
                <button data-bs-toggle="modal"
                data-bs-target="#onboardHorizontalImageModal"
                 class="btn btn-primary mt-4"><i class="ti ti-arrow-narrow-right"></i>Daftar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- /Invoice Add-->
      </div>
</div>

{{-- ================== KONFIRMASI PENDAFTARAN ============================ --}}
<div
  class="modal-onboarding modal fade animate__animated"
  id="onboardHorizontalImageModal"
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
      <div class="modal-body onboarding-horizontal p-0">
        <div class="onboarding-media">
          <img
            src="../../assets/img/illustrations/boy-verify-email-light.png"
            alt="boy-verify-email-light"
            width="273"
            class="img-fluid"
            data-app-light-img="illustrations/boy-verify-email-light.png"
            data-app-dark-img="illustrations/boy-verify-email-dark.png"
          />
        </div>
        <div class="onboarding-content mb-0">
          <h4 class="onboarding-title text-body text-danger">Daftar {{ $kkn->nama }}</h4>
          <small class="onboarding-info">
            Dengan mendaftar KKN {{ $kkn->nama }}, anda tidak bisa melakukan pendaftaran KKN lain.
          </small>
        </div>
      </div>
      <form method="POST" action="{{ route('daftar-kkn.store') }}"  enctype="multipart/form-data">
        @csrf
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary">Daftar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Mendapatkan nama dari elemen dengan id userName
        var userNameElement = document.getElementById("userName");
        var userName = userNameElement.textContent || userNameElement.innerText;

        // Menghasilkan inisial dua huruf dari seluruh nama (maksimal dua huruf)
        var initials = userName.match(/\b\w/g).slice(0, 2).join("").toUpperCase();

        // Menetapkan inisial ke elemen dengan id initials
        var initialsElement = document.getElementById("initials");
        initialsElement.textContent = initials;
    });
</script>
@endsection
