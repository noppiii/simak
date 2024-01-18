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
                    <h5 class="text-primary">Tambah Dosen Pembimbing Lapangan</h5>
                    <p>Di sini anda dapat menambahkan user sebagai dosen pembimbing lapangan, tolong isi form dengan benar</p>
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
             <form class="card-body" action="{{ route('generate.sertifikat.mhs',  ['nama' => request()->route('nama'), 'periode' => request()->route('periode'), request()->route('nim')]) }}" method="post" enctype="multipart/form-data">
                @csrf
              <h6>1. Informasi Pribadi</h6>
              <div class="row g-3">
                <div class="row mb-3 mt-4">
                    <label class="col-sm-2 form-label"  for="basic-icon-default-phone">Nama Mahasiswa</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="ti ti-user"></i
                        ></span>
                        <input
                          type="text"
                          class="form-control"
                          id="basic-icon-default-fullname"
                          placeholder="Masukan nama mahasiswa"
                          aria-describedby="basic-icon-default-fullname2"
                          value="{{ $luaran[0]['nama'] }}"
                          name="nama"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">NIM</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-phone2" class="input-group-text"
                          ><i class="ti ti-number"></i
                        ></span>
                        <input
                          type="text"
                          id="basic-icon-default-phone"
                          class="form-control phone-mask"
                          placeholder="Masukan nomor nim"
                          aria-describedby="basic-icon-default-phone2"
                          name="nim"
                          value="{{ $luaran[0]['nim'] }}"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Tempat/ Tanggal Lahir</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-phone2" class="input-group-text"
                          ><i class="ti ti-home"></i
                        ></span>
                        @php
                        $bulanIndonesia = [
                            'January' => 'Januari',
                            'February' => 'Februari',
                            'March' => 'Maret',
                            'April' => 'April',
                            'May' => 'Mei',
                            'June' => 'Juni',
                            'July' => 'Juli',
                            'August' => 'Agustus',
                            'September' => 'September',
                            'October' => 'Oktober',
                            'November' => 'November',
                            'December' => 'Desember',
                        ];

                        \Carbon\Carbon::setLocale('id');
                        @endphp

                        <input
                            type="text"
                            class="form-control"
                            id="basic-icon-default-fullname"
                            placeholder="Masukkan nama mahasiswa"
                            aria-describedby="basic-icon-default-fullname2"
                            value="{{ $luaran->isNotEmpty() ? $luaran[0]['tempat_lahir'] . ' / ' . \Carbon\Carbon::parse($luaran[0]['tanggal_lahir'])->isoFormat('D MMMM Y') : '' }}"
                            name="tempat_tanggal_lahir"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Fakultas/ Prodi</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-phone2" class="input-group-text"
                          ><i class="ti ti-building"></i
                        ></span>
                        <input
                          type="text"
                          id="basic-icon-default-phone"
                          class="form-control phone-mask"
                          placeholder="08xxxxxxxx"
                          aria-describedby="basic-icon-default-phone2"
                          name="telp"
                          value="{{ $namaFakultas . ' / ' . $namaProdi }}"
                          name="fakultas_prodi"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-message">Nama Kegiatan</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-message2" class="input-group-text"
                          ><i class="ti ti-text-wrap-disabled"></i
                        ></span>
                        <textarea
                          id="basic-icon-default-message"
                          class="form-control"
                          placeholder="Masukan alamat"
                          aria-label="Masukan alamat"
                          aria-describedby="basic-icon-default-message2"
                          name="nama_kegiatan"
                        >{{ $luaran[0]['nama_kegiatan'] }}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Tanggal Mulai</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-phone2" class="input-group-text"
                              ><i class="ti ti-calendar"></i
                            ></span>
                            <input
                            type="text"
                            id="basic-icon-default-phone"
                            class="form-control phone-mask"
                            placeholder="08xxxxxxxx"
                            aria-describedby="basic-icon-default-phone2"
                            name="tanggal_mulai"
                            value="{{ \Carbon\Carbon::parse($luaran[0]['tanggal_dimulai'])->isoFormat('D MMMM Y') }}"
                            />
                    </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Tanggal Selesai</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-phone2" class="input-group-text"
                              ><i class="ti ti-calendar"></i
                            ></span>
                            <input
                            type="text"
                            id="basic-icon-default-phone"
                            class="form-control phone-mask"
                            placeholder="08xxxxxxxx"
                            aria-describedby="basic-icon-default-phone2"
                            name="tanggal_selesai"
                            value="{{ \Carbon\Carbon::parse($luaran[0]['tanggal_diakhir'])->isoFormat('D MMMM Y') }}"
                            />
                        </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Nilai</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-phone2" class="input-group-text"
                          ><i class="ti ti-list-numbers"></i
                        ></span>
                        <input
                          type="text"
                          id="basic-icon-default-phone"
                          class="form-control phone-mask"
                          placeholder="08xxxxxxxx"
                          aria-describedby="basic-icon-default-phone2"
                          name="nilai"
                          value="{{ $mahasiswa[1]['nilai'] !== null ? $mahasiswa[1]['nilai'] : 'Belum Dinilai' }}"
                          readonly
                        />
                      </div>
                    </div>
                  </div>
              </div>
              <hr class="my-4 mx-n4" />
              <h6>2. Informasi Template Sertifikat</h6>
              <div class="row g-3">
                <div class="row mb-3 mt-4">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Tanggal Dibuat</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-phone2" class="input-group-text"
                              ><i class="ti ti-calendar"></i
                            ></span>
                            <input
                            type="text"
                            id="basic-icon-default-phone"
                            class="form-control phone-mask"
                            placeholder="08xxxxxxxx"
                            aria-describedby="basic-icon-default-phone2"
                            name="tanggal_dibuat"
                            value="{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}"
                            readonly
                            />
                        </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Template</label>
                    <div class="col-sm-10">
                        <div class="col-xl-12 mb-4">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md mb-md-0 mb-2">
                                    <div class="form-check custom-option custom-option-icon">
                                      <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                        <span class="custom-option-body">
                                          <i class="ti ti-certificate"></i>
                                          <span class="custom-option-title">Starter</span>
                                          <small> Cake sugar plum fruitcake I love sweet roll jelly-o.</small>
                                        </span>
                                        <input
                                          name="customRadioIcon"
                                          class="form-check-input"
                                          type="radio"
                                          value=""
                                          id="customRadioIcon1"
                                          checked
                                        />
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md mb-md-0 mb-2">
                                    <div class="form-check custom-option custom-option-icon">
                                      <label class="form-check-label custom-option-content" for="customRadioIcon2">
                                        <span class="custom-option-body">
                                          <i class="ti ti-user"></i>
                                          <span class="custom-option-title"> Personal </span>
                                          <small> Cake sugar plum fruitcake I love sweet roll jelly-o. </small>
                                        </span>
                                        <input
                                          name="customRadioIcon"
                                          class="form-check-input"
                                          type="radio"
                                          value=""
                                          id="customRadioIcon2"
                                        />
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                      <label class="form-check-label custom-option-content" for="customRadioIcon3">
                                        <span class="custom-option-body">
                                          <i class="ti ti-crown"></i>
                                          <span class="custom-option-title"> Enterprise </span>
                                          <small>Cake sugar plum fruitcake I love sweet roll jelly-o.</small>
                                        </span>
                                        <input
                                          name="customRadioIcon"
                                          class="form-check-input"
                                          type="radio"
                                          value=""
                                          id="customRadioIcon3"
                                        />
                                      </label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
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
