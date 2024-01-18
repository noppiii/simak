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
                    <h5 class="text-primary">Ajukan Luaran</h5>
                    <p>Di sini anda dapat mengajukan luaran yang sudah ditentukan, pastikan isi form data dengan benar</p>
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
          <div class="col-12 mb-4">
            <div class="bs-stepper wizard-numbered mt-2">
              <div class="bs-stepper-header">
                <div class="step" data-target="#kkn-details">
                  <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle">1</span>
                    <span class="bs-stepper-label">
                      <span class="bs-stepper-title">KKN</span>
                      <span class="bs-stepper-subtitle"><i class="ti ti-link me-1"></i>Informasi KKN</span>
                    </span>
                  </button>
                </div>
                <div class="step" data-target="#account-details">
                  <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle">2</span>
                    <span class="bs-stepper-label">
                      <span class="bs-stepper-title">Link</span>
                      <span class="bs-stepper-subtitle"><i class="ti ti-link me-1"></i>Link URL</span>
                    </span>
                  </button>
                </div>
                <div class="line">
                  <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step" data-target="#personal-info">
                  <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle">3</span>
                    <span class="bs-stepper-label">
                      <span class="bs-stepper-title">Berkas</span>
                      <span class="bs-stepper-subtitle"><i class="ti ti-file me-2"></i>File Berkas</span>
                    </span>
                  </button>
                </div>
                <div class="line">
                  <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step" data-target="#social-links">
                  <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle">4</span>
                    <span class="bs-stepper-label">
                      <span class="bs-stepper-title">Submit</span>
                      <span class="bs-stepper-subtitle"><i class="ti ti-viewport-wide me-1"></i>Preview Luaran</span>
                    </span>
                  </button>
                </div>
              </div>
              <div class="bs-stepper-content">
                <form action="{{ route('luaran.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                  <!-- Account Details -->
                  <div id="kkn-details" class="content">
                    <h6>1. Informasi Personal</h6>
                    <div class="row g-3">
                      <div class="row mb-3 mt-4">
                          <label class="col-sm-2 form-label"  for="basic-icon-default-phone">Nama Lengkap</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"
                                ><i class="ti ti-user"></i
                              ></span>
                              <input
                                type="text"
                                class="form-control"
                                placeholder="Masukan nama mahasiswa"
                                aria-describedby="basic-icon-default-fullname2"
                                id="linkInputKKNData1"
                                name="nama"
                                oninput="showDataKKN()"
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
                                class="form-control phone-mask"
                                placeholder="Masukan nomor nim"
                                aria-describedby="basic-icon-default-phone2"
                                id="linkInputKKNData2"
                                name="nim"
                                oninput="showDataKKN()"
                              />
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 form-label" for="basic-icon-default-phone">Tempat Lahir</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-phone2" class="input-group-text"
                                ><i class="ti ti-pin"></i
                              ></span>
                              <input
                                type="text"
                                class="form-control phone-mask"
                                placeholder="Masukan tempat lahir"
                                aria-describedby="basic-icon-default-phone2"
                                id="linkInputKKNData3"
                                name="tempat_lahir"
                                oninput="showDataKKN()"
                              />
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 form-label" for="basic-icon-default-phone">Tanggal Lahir</label>
                          <div class="col-sm-10">
                              <div class="input-group input-group-merge">
                                  <span id="basic-icon-default-phone2" class="input-group-text"
                                    ><i class="ti ti-calendar"></i
                                  ></span>
                                  <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" name="tanggal_lahir" oninput="showDataKKN()"/>
                                </div>
                          </div>
                        </div>
                        <hr class="my-4 mx-n4" />
                        <h6>2. Pelaksanaan Kegiatan</h6>
                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="basic-icon-default-phone">Nama Kegiatan</label>
                            <div class="col-sm-10">
                              <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"
                                  ><i class="ti ti-writing"></i
                                ></span>
                                <input
                                  type="text"
                                  class="form-control phone-mask"
                                  placeholder="Masukan nama kegiatan"
                                  aria-describedby="basic-icon-default-phone2"
                                  id="linkInputKKNData5"
                                  name="nama_kegiatan"
                                  oninput="showDataKKN()"
                                />
                              </div>
                            </div>
                          </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 form-label" for="basic-icon-default-phone">Tanggal Dimulai Kegiatan</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"
                                  ><i class="ti ti-calendar-plus"></i
                                ></span>
                                <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date2" name="tanggal_dimulai" oninput="showDataKKN()" />
                              </div>
                        </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 form-label" for="basic-icon-default-message">Tanggal Diakhir Kegiatan</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"
                                  ><i class="ti ti-calendar-minus"></i
                                ></span>
                                <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date3" name="tanggal_diakhir" oninput="showDataKKN()" />
                              </div>
                        </div>
                        </div>
                      <div class="col-12 d-flex justify-content-between">
                        <div class="btn btn-label-secondary btn-prev" disabled>
                          <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                          <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </div>
                        <div class="btn btn-primary btn-next">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                          <i class="ti ti-arrow-right"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="account-details" class="content">
                    <div class="row g-3">
                        <div class="row mb-3 mt-4">
                            <label class="col-sm-2 form-label"  for="basic-icon-default-phone">Link URL</label>
                            <div class="col-sm-10" id="form-container">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="ti ti-link"></i>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Masukkan link URL"
                                        aria-describedby="basic-icon-default-fullname2"
                                        name="link_berkas[]"
                                        id="linkInputData"
                                        oninput="showDataLink()"
                                    />
                                </div>
                            </div>
                            <div class="mt-2 d-flex justify-content-center">
                                <button type="button" class="btn btn-sm btn-primary add-button mx-1" onclick="addLinkForm()">
                                    <i class="ti ti-plus me-1"></i>
                                    <span class="align-middle">Add</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger remove-button mx-1" onclick="removeLinkForm()">
                                    <i class="ti ti-trash me-1"></i>
                                    <span class="align-middle">Remove</span>
                                </button>
                            </div>
                          </div>
                      <div class="col-12 d-flex justify-content-between">
                        <div class="btn btn-label-secondary btn-prev" disabled>
                          <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                          <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </div>
                        <div class="btn btn-primary btn-next">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                          <i class="ti ti-arrow-right"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Personal Info -->
                  <div id="personal-info" class="content">
                    <div class="row g-3">
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
                                        <input type="file" id="fileInput" name="file_berkas[]" class="d-none">
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
                            <div class="mt-2 d-flex justify-content-center">
                                <button type="button" class="btn btn-sm btn-primary add-button2 mx-1">
                                    <i class="ti ti-plus me-1"></i>
                                    <span class="align-middle">Add</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger remove-button2 mx-1">
                                    <i class="ti ti-trash me-1"></i>
                                    <span class="align-middle">Remove</span>
                                </button>
                            </div>
                        </div>
                      </div>
                      <div class="col-12 d-flex justify-content-between">
                        <div class="btn btn-label-secondary btn-prev">
                          <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                          <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </div>
                        <div class="btn btn-primary btn-next">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                          <i class="ti ti-arrow-right"></i>
                        </div>
                      </div>
                    </div>
                    <!-- Social Links -->
                    <div id="social-links" class="content">
                      <div class="content-header mb-3">
                        <h6 class="mb-0">Preview Luaran</h6>
                        <small>Cek luaran yang akan anda ajukan. pastikan data yang diajukan sudah benar</small>
                      </div>
                      <div class="row g-3">
                        <div class="col-sm-8">
                          <ul class="timeline mb-0">
                            <li class="timeline-item timeline-item-transparent">
                              <span class="timeline-point timeline-point-danger"></span>
                              <div class="timeline-event" >
                                <div class="timeline-header mb-1">
                                  <h6 class="mb-0">KKN</h6>
                                </div>
                                <p class="mb-2" id="outputkknData"></p>
                                <p class="mb-2" id="outputkknData2"></p>
                                <p class="mb-2" id="outputkknData3"></p>
                                <p class="mb-2" id="outputkknData4"></p>
                                <p class="mb-2" id="outputkknData5"></p>
                                <p class="mb-2" id="outputkknData6"></p>
                                <p class="mb-2" id="outputkknData7"></p>
                              </div>
                            </li>
                            <li class="timeline-item timeline-item-transparent">
                              <span class="timeline-point timeline-point-primary"></span>
                              <div class="timeline-event" >
                                <div class="timeline-header mb-1">
                                  <h6 class="mb-0">Link URL</h6>
                                </div>
                                <p class="mb-2" id="outputData"></p>
                                <p class="mb-2" id="outputData2"></p>
                              </div>
                            </li>
                            <li class="timeline-item timeline-item-transparent border-0">
                                <span class="timeline-point timeline-point-info"></span>
                                <div class="timeline-event">
                                  <div class="timeline-header mb-1">
                                    <h6 class="mb-0">File Berkas</h6>
                                  </div>
                                  <p class="mb-0" id="fileOutputData"></p>
                                </div>
                              </li>
                          </ul>
                        </div>
                        <div class="col-12 d-flex justify-content-between">
                          <div class="btn btn-label-secondary btn-prev">
                            <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                          </div>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
  </div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const formContainer = document.getElementById("form-container");
        const addButton = document.querySelector(".add-button");
        const removeButton = document.querySelector(".remove-button");
        const displayContainer = document.getElementById("outputData2");

        let formCount = 1;
        let formData = [];

        addButton.addEventListener("click", function () {
            formCount++;
            const newInput = document.createElement("div");
            const dynamicLinkId = `linkInput${formCount}`;
            newInput.innerHTML = `
                <div class="col-md-12 mt-2">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="ti ti-link"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Masukkan link URL ${formCount}"
                            aria-describedby="basic-icon-default-fullname2"
                            name="link_berkas[]"
                            id="${dynamicLinkId}"
                            oninput="showData('${dynamicLinkId}')"
                        />
                    </div>
                </div>
            `;
            formContainer.appendChild(newInput);

            // Menambahkan elemen baru ke formData untuk menangani formulir baru
            formData.push('');

            // Menambahkan elemen <p> untuk menampilkan data
            const displayElement = document.createElement("p");
            displayElement.id = `displayData${formCount}`;
            displayContainer.appendChild(displayElement);
        });

        removeButton.addEventListener("click", function () {
            if (formCount > 1) {
                const lastInput = formContainer.lastElementChild;
                formContainer.removeChild(lastInput);
                formCount--;

                // Menghapus elemen terakhir dari formData untuk menangani formulir yang dihapus
                formData.pop();

                // Menghapus elemen <p> untuk menampilkan data formulir yang dihapus
                const lastDisplayElement = displayContainer.lastElementChild;
                displayContainer.removeChild(lastDisplayElement);
            }
        });

        // Function to show data in the <p> element
        window.showData = function (elementId) {
            const inputElement = document.getElementById(elementId);
            const inputIndex = elementId.replace("linkInput", "") - 1;
            formData[inputIndex] = inputElement.value;
            const displayElement = document.getElementById(`displayData${inputIndex + 1}`);
            displayElement.innerHTML = `<i class="ti ti-link me-1"></i> ${formData[inputIndex]}`;
        };
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const formContainer = document.getElementById("form-container2");
    const addButton = document.querySelector(".add-button2");
    const removeButton = document.querySelector(".remove-button2");

    let formCount = 1;

    addButton.addEventListener("click", function () {
        formCount++;
        const newInput = document.createElement("div");
        newInput.innerHTML = `
            <div class="row mb-3" id="fileUploadSection">
                <div class="col-sm-12" id="form-container2">
                    <div class="file-uploader px-2 py-3 mb-5 text-center">
                        <label for="fileInput${formCount}" class="text-primary text-bold cursor-pointer">
                            <div class="icon-container mb-2 mx-auto d-flex justify-content-center align-items-center">
                                <span class="fa-stack fa-lg">
                                    <span class="primary-icon fas fa-file-alt fa-stack-2x"></span>
                                    <span class="downloading-icon fas fas fa-chevron-circle-down fa-stack-1x"></span>
                                </span>
                            </div>
                            <div class="file-uploader-body mb-2">
                                <input type="file" id="fileInput${formCount}" name="file_berkas[]" class="d-none file-input">
                                <p class="file-upload-instructions">
                                    <label for="fileInput${formCount}" class="text-primary text-bold cursor-pointer">Cari dokumen</label>
                                    <span class="hide-non-touch">atau drag and drop dokumen disini</span> untuk upload
                                </p>
                                <p class="drop-cta">Drop dokumen untuk upload</p>
                                <p id="fileList${formCount}" class="file-list"></p>
                            </div>
                            <div class="file-uploader-footer hide-non-touch">
                                <p><small>PDF dan DOCX dibawah 20MB diizinkan</small></p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        `;
        formContainer.appendChild(newInput);

        // Add event listeners for the new file input
        const newFileInput = document.getElementById(`fileInput${formCount}`);
        const newFileUploader = newInput.querySelector('.file-uploader');
        addDragAndDropFunctionality(newFileInput, newFileUploader);
    });

    removeButton.addEventListener("click", function () {
        if (formCount > 1) {
            const lastInput = formContainer.lastElementChild;
            formContainer.removeChild(lastInput);
            formCount--;
        }
    });

    // Add initial drag and drop functionality for the first file input
    const initialFileInput = document.getElementById("fileInput");
    const initialFileUploader = formContainer.querySelector('.file-uploader');
    addDragAndDropFunctionality(initialFileInput, initialFileUploader);

    function addDragAndDropFunctionality(fileInput, fileUploader) {
        fileUploader.addEventListener('dragover', function (e) {
            e.preventDefault();
            fileUploader.classList.add('is-dragover');
        });

        fileUploader.addEventListener('dragleave', function () {
            fileUploader.classList.remove('is-dragover');
        });

        fileUploader.addEventListener('drop', function (e) {
            e.preventDefault();
            fileUploader.classList.remove('is-dragover');
            handleFiles(e.dataTransfer.files, fileUploader);
        });

        fileInput.addEventListener('change', function () {
            handleFiles(fileInput.files, fileUploader);
        });
    }

    function handleFiles(files, fileUploader) {
        const fileList = fileUploader.querySelector('.file-list');
        const fileOutputData = document.getElementById('fileOutputData');

        // Clear previous file list
        fileList.innerHTML = '';

        for (const file of files) {
            const listItem = document.createElement('p');
            listItem.textContent = file.name;
            fileList.appendChild(listItem);
        }

        // Display file names in the specified <p> element
          fileOutputData.innerHTML += Array.from(files).map(file => `<i class="ti ti-file me-1"></i> ${file.name}`).join('<br>- ') + '<br>';
    }
});

</script>
<script>
    // Define the showDataKKN function
    function showDataKKN() {
        var inputKKNValue1 = document.getElementById('linkInputKKNData1').value;

        document.getElementById('outputkknData').innerHTML = '<i class="ti ti-user me-1"></i> ' + inputKKNValue1;
    }
</script>
<script>
     function showDataKKN() {
            var inputKKNValue1 = document.getElementById('linkInputKKNData1').value;
            var inputKKNValue2 = document.getElementById('linkInputKKNData2').value;
            var inputKKNValue3 = document.getElementById('linkInputKKNData3').value;
            var inputKKNValue4 = document.getElementById('flatpickr-date').value;
            var inputKKNValue5 = document.getElementById('linkInputKKNData5').value;
            var inputKKNValue6 = document.getElementById('flatpickr-date2').value;
            var inputKKNValue7 = document.getElementById('flatpickr-date3').value;

            document.getElementById('outputkknData').innerHTML = '<i class="ti ti-user me-1"></i> ' + inputKKNValue1;
            document.getElementById('outputkknData2').innerHTML = '<i class="ti ti-number me-1"></i> ' + inputKKNValue2;
            document.getElementById('outputkknData3').innerHTML = '<i class="ti ti-pin me-1"></i> ' + inputKKNValue3;
            document.getElementById('outputkknData4').innerHTML = '<i class="ti ti-calendar me-1"></i> ' + inputKKNValue4;
            document.getElementById('outputkknData5').innerHTML = '<i class="ti ti-writing me-1"></i> ' + inputKKNValue5;
            document.getElementById('outputkknData6').innerHTML = '<i class="ti ti-calendar-plus me-1"></i> ' + inputKKNValue6;
            document.getElementById('outputkknData7').innerHTML = '<i class="ti ti-calendar-minus me-1"></i> ' + inputKKNValue7;
        }
    function showDataLink() {
        // Mendapatkan nilai dari input
        var inputValue = document.getElementById('linkInputData').value;

        // Menampilkan nilai di bawah input dengan ikon
        document.getElementById('outputData').innerHTML = '<i class="ti ti-link me-1"></i> ' + inputValue;
    }

</script>
@push('script')
<script src="{{ asset('assets/js/form-wizard-numbered.js') }}"></script>
@endpush
@endsection
