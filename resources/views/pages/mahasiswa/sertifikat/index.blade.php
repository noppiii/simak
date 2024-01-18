@extends('layouts.admin.main')
@section('title')
    Admin || Admin
@endsection
@section('pages')
    Master Admin
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if ($sertifikat->isNotEmpty())
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
              <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                  <div class="card-body">
                    <h5 class="text-primary">Welcome {{ Auth::guard('authuser')->user()->mahasiswa->nama }}! 🎉</h5>
                    <p>Di sini Anda dapat mengontrol dan mengelola semua luaran yang diperlukan</p>
                    <a href="{{ route('luaran.create') }}" class="btn btn-md btn-primary">Ajukan Luaran</a>
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
        </div>
    @else
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6 text-center">
                <img
                    src="{{ asset('image/sertifikat-tidak-tersedia.png') }}"
                    class="img-fluid"
                    alt="Layout container"
                />
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
