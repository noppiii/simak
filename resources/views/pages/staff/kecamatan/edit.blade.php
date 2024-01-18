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
            <form class="card-body" action="{{ route('daerah-kecamatan.update', $kecamatan->kecamatan_id) }}" method="post" enctype="multipart/form-data">                @csrf
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="row mb-3 mt-4">
                        <label class="col-sm-2 form-label" for="basic-icon-default-email">Nama kecamatan</label>
                        <div class="col-sm-10">
                          <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-signature"></i></span>
                            <input
                            id="modalAddCard"
                            class="form-control credit-card-mask"
                            type="text"
                            placeholder="Masukan nama kecamatan"
                            aria-describedby="modalAddCard2"
                            name="nama"
                            value="{{ $kecamatan->nama }}"
                          />
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="basic-icon-default-email">Kabupaten</label>
                        <div class="col-sm-10">
                            <select id="select2Icons" name="kabupaten_id" class="select2-icons form-select">
                                @foreach($kabupaten as $data)
                                <option value="{{ $data->kabupaten_id }}" @if (old('kabupaten', $kecamatan->kabupaten->kabupaten_id) == $data->kabupaten_id)
                                    selected @endif data-icon="ti ti-building">{{ $data->nama }}</option>
                            @endforeach
                              </select>
                        </div>
                      </div>
                  </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div>
              </form>
          </div>
    </div>
  </div>

@endsection
