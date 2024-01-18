@extends('layouts.admin.main')
@section('title')
    Admin || Admin
@endsection
@section('pages')
        Update Admin
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
              <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                  <div class="card-body">
                    <h5 class="text-primary">Tambah Admin</h5>
                    <p>Di sini anda dapat menambahkan user sebagai admin, tolong isi form dengan benar</p>
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
            <form class="card-body" action="{{ route('luaran.update', $luaran->berkas_id) }}" method="post" enctype="multipart/form-data">                @csrf
                @csrf
                @method('PUT')
                @if ($luaran->file_berkas == null)
                <div class="row g-3">
                  <div class="row mb-3 mt-4">
                      <label class="col-sm-2 form-label" for="basic-icon-default-email">Link URL</label>
                      <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                          <span class="input-group-text"><i class="ti ti-link"></i></span>
                          <input
                            type="text"
                            id="basic-icon-default-email"
                            class="form-control"
                            placeholder="Masukan Link URL baru..."
                            aria-describedby="basic-icon-default-email2"
                            name="link_berkas"
                          />
                        </div>
                      </div>
                    </div>
                </div>
                @elseif ($luaran->link_berkas == null)
                <div class="row mb-3" id="fileUploadSection">
                    <label class="col-sm-2 form-label" for="multicol-password">File Berkas</label>
                    <div class="col-sm-10" id="form-container2">
                        <div class="file-uploader px-2 py-3 mb-5 text-center">
                            <label for="fileInput" class="text-primary text-bold cursor-pointer">
                            <div class="icon-container mb-2 mx-auto d-flex justify-content-center align-items-center">
                                <span class="fa-stack fa-lg">
                                    <span class="primary-icon fas fa-file-alt fa-stack-2x"></span>
                                    <span class="downloading-icon fas fas fa-chevron-circle-down fa-stack-1x"></span>
                                </span>
                            </div>
                            <div class="file-uploader-body mb-2">
                                <input type="file" id="fileInput" name="file_berkas" class="d-none">
                                <p class="file-upload-instructions">
                                    <label for="fileInput" class="text-primary text-bold cursor-pointer">Cari dokumen</label>
                                    <span class="hide-non-touch">atau drag and drop dokumen disini</span> untuk upload
                                </p>
                                <p class="drop-cta">Drop dokumen untuk upload</p>
                                <ul id="fileList" class="file-list"></ul>
                            </div>
                            <div class="file-uploader-footer hide-non-touch">
                                <p><small>PDF dan DOCX dibawah 20MB diizinkan</small></p>
                            </div>
                            </label>
                        </div>
                    </div>
                </div>
                @endif
              <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                <button type="reset" class="btn btn-label-secondary">Cancel</button>
              </div>
            </form>
          </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <script>
      $('.file-uploader').on('dragover dragenter', function (e) {
    e.preventDefault();
    $(this).addClass('is-dragover');
}).on('dragleave dragend drop', function () {
    $(this).removeClass('is-dragover');
});

$(function () {
    var dropzoneCounter = 0;

    $('.file-uploader').on('dragenter', function () {
        dropzoneCounter++;
        var $this = $(this);
        $this.addClass('is-dragover');
    });

    $('.file-uploader').bind('dragleave', function () {
        dropzoneCounter--;
        if (dropzoneCounter === 0) {
            $(this).removeClass('is-dragover');
        }
    });

    $('.file-uploader').bind('drop', function (e) {
        e.preventDefault();
        dropzoneCounter = 0;
        $(this).removeClass('is-dragover');
        handleFiles(e.originalEvent.dataTransfer.files, $(this));
    });

    $('#fileInput').on('change', function () {
        handleFiles(this.files, $('.file-uploader'));
    });

    function handleFiles(files, $uploader) {
        var $fileList = $uploader.find('#fileList');
        $fileList.empty();
        for (var i = 0; i < files.length; i++) {
            $fileList.append('<li>' + files[i].name + '</li>');
        }
        // Perform additional logic with the files
        // For example, you can trigger an AJAX request to upload the files.
    }
});

  </script>


@endsection
