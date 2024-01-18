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
                    <h5 class="text-primary">Tambah KKN</h5>
                    <p>Di sini anda dapat menambahkan user sebagai KKN, tolong isi form dengan benar</p>
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
             <form class="card-body form-repeater" action="{{ route('kkn.store') }}" method="post" enctype="multipart/form-data">
                @csrf
              <h6>1. Informasi KKN</h6>
              <div class="row g-3">
                <div class="row mb-3 mt-4">
                    <label class="col-sm-2 form-label"  for="basic-icon-default-phone">Nama KKN</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="ti ti-signature"></i
                        ></span>
                        <input
                          type="text"
                          class="form-control"
                          id="basic-icon-default-fullname"
                          placeholder="Masukan nama KKN"
                          aria-describedby="basic-icon-default-fullname2"
                          name="nama"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-message">Deskripsi</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-message2" class="input-group-text"
                          ><i class="ti ti-text-wrap-disabled"></i
                        ></span>
                        <textarea
                          id="basic-icon-default-message"
                          class="form-control"
                          placeholder="Masukan deskripsi"
                          aria-label="Masukan deskripsi"
                          aria-describedby="basic-icon-default-message2"
                          name="deskripsi"
                        ></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Tanggal Mulai</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-phone2" class="input-group-text"
                          ><i class="ti ti-calendar-plus"></i
                        ></span>
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" name="tanggal_mulai" />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Tanggal Selesai</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-phone2" class="input-group-text"
                              ><i class="ti ti-calendar-minus"></i
                            ></span>
                            <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date2" name="tanggal_selesai" />
                          </div>
                    </div>
                  </div>
              </div>
              <hr class="my-4 mx-n4" />
              <h6>2. Penataan KKN</h6>
              <div class="row g-3">
                <div class="row mb-3 mt-4">
                    <label class="col-sm-2 form-label" for="basic-icon-default-email">Lokasi KKN</label>
                    <div class="col-sm-10">
                        <select id="select2Icons" name="desa_id" class="select2-icons form-select">
                            @foreach($desa as $data)
                                <option value="{{ $data->desa_id }}" data-icon="ti ti-map-pin">Desa {{ $data->nama }}
                                , Kecamatan {{ $data->kecamatan->nama }}, Kabupaten {{ $data->kecamatan->kabupaten->nama }}</option>
                            @endforeach
                          </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="multicol-password">Periode</label>
                    <div class="col-sm-10">
                        <select id="select2Basic" name="periode_id" class="select2-icons form-select">
                            @foreach($periode as $data)
                                <option value="{{ $data->periode_id }}" data-icon="ti ti-calendar-event">{{ $data->nama }}</option>
                            @endforeach
                          </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="multicol-password">Skema KKN</label>
                    <div class="col-sm-10">
                        <select id="select2Icons2" name="skema_id" class="select2-icons form-select">
                            @foreach($skema as $data)
                                <option value="{{ $data->skema_id }}" data-icon="ti ti-category-2">{{ $data->nama }}</option>
                            @endforeach
                          </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-phone">Batas Pendaftaran</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-phone2" class="input-group-text"
                              ><i class="ti ti-calendar-minus"></i
                            ></span>
                            <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date3" name="tanggal_pendaftaran" />
                          </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="multicol-password">Persyaratan</label>
                    <div class="col-sm-10" id="form-container">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-fullname2" class="input-group-text">
                                <i class="ti ti-clipboard-text"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Masukkan nama persyaratan"
                                aria-describedby="basic-icon-default-fullname2"
                                name="nama_persyaratan[]"
                            />
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-center">
                        <button type="button" class="btn btn-sm btn-primary add-button mx-1">
                            <i class="ti ti-plus me-1"></i>
                            <span class="align-middle">Add</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger remove-button mx-1">
                            <i class="ti ti-trash me-1"></i>
                            <span class="align-middle">Remove</span>
                        </button>
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
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        const formContainer = document.getElementById("form-container");
        const addButton = document.querySelector(".add-button");
        const removeButton = document.querySelector(".remove-button");

        let formCount = 1;

        addButton.addEventListener("click", function () {
            formCount++;
            const newInput = document.createElement("div");
            newInput.innerHTML = `
                <div class="col-md-12 mt-2">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="ti ti-clipboard-text"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Masukkan nama persyaratan ${formCount}"
                            aria-describedby="basic-icon-default-fullname2"
                            name="nama_persyaratan[]"
                        />
                    </div>
                </div>
            `;
            formContainer.appendChild(newInput);
        });

        removeButton.addEventListener("click", function () {
            if (formCount > 1) {
                const lastInput = formContainer.lastElementChild;
                formContainer.removeChild(lastInput);
                formCount--;
            }
        });
    });
</script>

@endsection
