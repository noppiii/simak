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
                            <button
                            type="button"
                            class="btn btn-primary text-sm mb-1"
                            data-bs-toggle="modal"
                            data-bs-target="#addNewCCModal"
                          >
                            <small>Generate Kelompok</small>
                          </button>
                            <small class="mb-0 mt-1">Buat Kelompok KKN</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              <div class="container-xxl flex-grow-1 container-p-y">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <form action="{{ route('list.kkn.kelompok', ['nama' => request()->route('nama'), 'periode' => request()->route('periode')]) }}" method="GET">
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
                            </div>
                        </form>
                    </div>
                </div>
                 <!-- Teams Cards -->
                 <div class="row g-4 mb-4">
                    @unless ($search)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex justify-content-between">
                            <h6 class="fw-normal mb-2">Total {{ $kkn->kknMahasiswas->count() }} Peserta</h6>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                @php
                                $displayedNames = [];
                                $displayedCount = 0;
                                @endphp
                                @foreach ($kkn->kknMahasiswas as $kknMahasiswaData)
                                    @if ($kknMahasiswaData->mahasiswa && !in_array($kknMahasiswaData->mahasiswa->foto, $displayedNames) &&  $displayedCount < 4)
                                        <li data-bs-toggle="tooltip"
                                            data-popup="tooltip-custom"
                                            data-bs-placement="top"
                                            title="{{ $kknMahasiswaData->mahasiswa->nama }}"
                                            class="avatar avatar-sm pull-up">
                                            <img class="rounded-circle" src="{{ asset('store/user/photo/mahasiswa/' .   $kknMahasiswaData->mahasiswa->foto) }}" alt="Avatar" />
                                        </li>
                                        @php
                                            $displayedNames[] = $kknMahasiswaData->mahasiswa->nama;
                                            $displayedCount++;
                                        @endphp
                                    @endif
                                @endforeach
                              <li class="avatar avatar-sm">
                                <span
                                  class="avatar-initial rounded-circle pull-up"
                                  data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  title="{{ $kkn->kknMahasiswas->count() - 4 }} more"
                                  >+{{ $kkn->kknMahasiswas->count() - 4 }}</span
                                >
                              </li>
                            </ul>
                          </div>
                          <div class="d-flex justify-content-between align-items-end mt-1">
                            <div class="role-heading">
                              <h4 class="mb-1">Semua Peserta</h4>
                              <a
                                href="{{ route('list.kkn.peserta', ['nama' => $kkn->nama, 'periode' => $kkn->periode->nama]) }}"
                                class="role-edit-modal"
                                ><span>Detail</span></a
                              >
                            </div>
                            <a href="{{ route('list.kkn.peserta', ['nama' => $kkn->nama, 'periode' => $kkn->periode->nama]) }}" class="text-muted"><i class="ti ti-arrow-narrow-right ti-md"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endunless
                    @if(count($paginatedItems) > 0)
                    @foreach ($paginatedItems as $data)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex justify-content-between">
                            <h6 class="fw-normal mb-2">Total {{ $data->kknMahasiswas->count() }} Peserta</h6>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                @php
                                $displayedNames = [];
                                $displayedCount = 0;
                                @endphp
                                @foreach ($data->kknMahasiswas as $kknMahasiswaData)
                                    @if ($kknMahasiswaData->mahasiswa && !in_array($kknMahasiswaData->mahasiswa->foto, $displayedNames) &&  $displayedCount < 4)
                                        <li data-bs-toggle="tooltip"
                                            data-popup="tooltip-custom"
                                            data-bs-placement="top"
                                            title="{{ $kknMahasiswaData->mahasiswa->nama }}"
                                            class="avatar avatar-sm pull-up">
                                            <img class="rounded-circle" src="{{ asset('store/user/photo/mahasiswa/' .   $kknMahasiswaData->mahasiswa->foto) }}" alt="Avatar" />
                                        </li>
                                        @php
                                            $displayedNames[] = $kknMahasiswaData->mahasiswa->nama;
                                            $displayedCount++;
                                        @endphp
                                    @endif
                                @endforeach
                              <li class="avatar avatar-sm">
                                <span
                                  class="avatar-initial rounded-circle pull-up"
                                  data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  title="{{ $data->kknMahasiswas->count() - 4 }} more"
                                  >+{{ $data->kknMahasiswas->count() - 4 }}</span
                                >
                              </li>
                            </ul>
                          </div>
                          <div class="d-flex justify-content-between align-items-end mt-1">
                            <div class="role-heading">
                              <a href="{{ route('list.anggota.kelompok', ['nama' => $kkn->nama, 'periode' => $kkn->periode->nama, 'kelompok_id' => $data->kelompok_id ]) }}" class="h4 mb-1">{{ $data->nama }}</a>
                              <a
                                href="javascript:;"
                                data-bs-toggle="modal"
                                data-bs-target="#addRoleModal"
                                class="role-edit-modal d-block"
                                >
                                @php
                                    $displayedNames = [];
                                @endphp
                                @foreach ($data->kknMahasiswas as $kknMahasiswaData)
                                    @if ($kknMahasiswaData->dpl && !in_array($kknMahasiswaData->dpl->nama, $displayedNames))
                                        <span>
                                            @if ($kknMahasiswaData->dpl === null || $kknMahasiswaData->dpl === "")
                                            <span class="text-danger">Belum Ada DPL</span>
                                            @else
                                            {{ $kknMahasiswaData->dpl->nama }}
                                            @endif
                                        </span>
                                        @php
                                            $displayedNames[] = $kknMahasiswaData->dpl->nama;
                                        @endphp
                                    @endif
                                @endforeach
                                </a
                              >
                            </div>
                            <a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#onboardHorizontalImageModal{{ $data->kelompok_id }}" class="text-muted"><i class="ti ti-trash-x ti-md text-danger"></i></a>
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
                        @if ($paginatedItems->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $paginatedItems->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        @endif

                        <!-- Tombol Halaman -->
                        @foreach ($paginatedItems->getUrlRange(1, $paginatedItems->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $paginatedItems->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <!-- Tombol Next -->
                        @if ($paginatedItems->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $paginatedItems->nextPageUrl() }}" aria-label="Next">
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

  {{-- ================= GENERATE KELOMPOK FORM ===================== --}}
  <div class="modal fade" id="addNewCCModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h3 class="mb-2">Generate Kelompok</h3>
            <p class="text-muted">Generate kelompok {{ $kkn->nama }}</p>
          </div>
          <form id="addNewCCForm" class="row g-3" action="{{ route('generate.kelompok', ['kknId' => $kkn->kkn_id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-12">
                <label class="form-label w-100" for="banyakAnggota">Banyak Anggota Dalam Kelompok</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="ti ti-user"></i></span>
                    <input
                        id="banyakAnggota"
                        class="form-control"
                        type="number"
                        placeholder="Masukkan jumlah anggota dalam kelompok"
                        aria-describedby="modalAddCard2"
                        name="banyak_anggota"
                    />
                </div>
            </div>
            <div class="col-12">
                <label class="form-label w-100" for="komposisiGender">Komposisi Gender</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="ti ti-gender-androgyne"></i></span>
                    <input
                        id="komposisiGender"
                        class="form-control"
                        type="number"
                        placeholder="Komposisi perbandingan laki-laki dengan perempuan"
                        aria-describedby="modalAddCard2"
                        name="komposisi_gender"
                        min="0"
                        max="100"
                        step="any"
                    />
                    <span class="input-group-text">%</span>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label w-100" for="komposisiProdi">Komposisi Program Studi</label>
                <div class="form-repeater">
                    <div data-repeater-list="komposisi_prodi">
                        <div data-repeater-item>
                            <div class="row">
                                <div class="mb-3 col-lg-6 col-xl-8 col-12 mb-0">
                                    <label class="form-label" for="form-repeater-1-1">Program Studi</label>
                                    <select id="form-repeater-1-4" name="komposisi_prodi" class="form-select">
                                        <!-- Options will be dynamically added here using JavaScript -->
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-xl-4 col-12 mb-0">
                                    <label class="form-label" for="form-repeater-1-2">Prosentase</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="ti ti-building"></i></span>
                                        <input
                                            id="prosentase_prodi"
                                            class="form-control"
                                            type="number"
                                            placeholder="Prosentase"
                                            aria-describedby="modalAddCard2"
                                            name="prosentase_prodi"
                                            min="0"
                                            max="100"
                                            step="any"
                                        />
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="mb-3 col-lg-12 col-xl-4 col-12 d-flex align-items-center mb-0">
                                    <div class="btn btn-label-danger mt-4" data-repeater-delete>
                                        <i class="ti ti-x ti-xs me-1"></i>
                                        <span class="align-middle">Delete</span>
                                    </div>
                                </div>
                            </div>
                            <hr />
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="btn btn-primary" data-repeater-create>
                            <i class="ti ti-plus me-1"></i>
                            <span class="align-middle">Add</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label w-100" for="listAnggota">List Anggota</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="ti ti-users"></i></span>
                    <textarea
                        id="pesertaListTextarea"
                        class="form-control"
                        placeholder="Masukan alamat"
                        aria-label="Masukan alamat"
                        aria-describedby="basic-icon-default-message2"
                        style="height: 150px;"
                        name="list_anggota"
                    ></textarea>
                </div>
                {{-- <textarea
                    id="pesertaKelaminListTextarea"
                    class="form-control"
                    placeholder="Masukan alamat"
                    aria-label="Masukan alamat"
                    aria-describedby="basic-icon-default-message2"
                    style="height: 150px;"
                    name="list_kelamin_anggota"

                ></textarea> --}}
            </div>
            <div class="col-12 text-center">
                <button type="button" class="btn btn-info me-sm-3 me-1" id="ambilDataPesertaBtn">Ambil Data Peserta</button>
            </div>
            <div class="col-12 text-center">
              <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
              <button
                type="reset"
                class="btn btn-label-secondary btn-reset"
                data-bs-dismiss="modal"
                aria-label="Close"
              >
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- =================== DELETE KELOMPOK =================== --}}
  @foreach ($kelompokList as $data)
  <div class="modal-onboarding modal fade animate__animated" id="onboardHorizontalImageModal{{ $data->kelompok_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content text-center">
        <div class="modal-header border-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body onboarding-horizontal p-0">
          <div class="onboarding-media">
            <img src="../../assets/img/illustrations/boy-verify-email-light.png" alt="boy-verify-email-light" width="273" class="img-fluid" data-app-light-img="illustrations/boy-verify-email-light.png" data-app-dark-img="illustrations/boy-verify-email-dark.png" />
          </div>
          <div class="onboarding-content mb-0">
            <h4 class="onboarding-title text-body text-danger">Hapus {{ $data->nama }}</h4>
            <small class="onboarding-info">
              Dengan menghapus {{ $data->nama }}, data KKN ini akan terhapus secara permanen.
            </small>
          </div>
        </div>
        <form method="POST" action="{{ route('delete.kelompok', ['nama' => $kkn->nama, 'periode' => $kkn->periode->nama, 'kelompok_id' => $data->kelompok_id ]) }}">
          @csrf
          @method('DELETE')
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach

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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#ambilDataPesertaBtn').on('click', function () {
            $.ajax({
                url: '{{ route('get.peserta.data', ['nama' => $kkn->nama, 'periode' => $kkn->periode->nama]) }}',
                method: 'GET',
                success: function (data) {
                    // Check if the returned data is an object
                    if (typeof data === 'object') {
                        // Extract information from the data
                        var pesertaInfo = Object.values(data).map(function (item) {
                            return {
                                nama: item.nama,
                                jenis_kelamin: item.jenis_kelamin,
                                nama_prodi: item.nama_prodi
                            };
                        });

                        // Create a formatted string with the information
                        var pesertaString = pesertaInfo.map(function (info) {
                            return info.nama + ' (' + info.jenis_kelamin + ', ' + (info.nama_prodi || 'Prodi not available') + ')';
                        }).join(', ');

                        // Update the textarea with the formatted string
                        $('#pesertaListTextarea').val(pesertaString);
                    } else {
                        // Handle the case where the returned data is not in the expected format
                        alert('Invalid data format');
                    }
                },
                error: function (xhr, status, error) {
                    alert('Failed to fetch data: ' + error);
                }
            });
        });
    });
</script>

<script>
$(document).ready(function () {
    var uniqueDataArray = [];  // Array to store unique values

    $('#ambilDataPesertaBtn').on('click', function () {
        $.ajax({
            url: '{{ route('get.prodi.data', ['nama' => $kkn->nama, 'periode' => $kkn->periode->nama]) }}',
            method: 'GET',
            success: function (data) {
                var selectOptions = '';

                // Clear existing options for all selects inside repeater
                $('.form-repeater select').empty();
                uniqueDataArray = [];  // Clear the array

                // Loop through each repeated item and update select options
                $('.form-repeater [data-repeater-item]').each(function () {
                    var $select = $(this).find('select');
                    var uniqueData = Object.values(data);

                    // Add options for each value in uniqueData
                    $.each(uniqueData, function (index, value) {
                        // Check if the value is not already in the array before adding
                        if (uniqueDataArray.indexOf(value) === -1) {
                            uniqueDataArray.push(value);
                            selectOptions += '<option value="' + value + '" data-icon="ti ti-location">' + value + '</option>';
                        }
                    });

                    // Update the select inside the current repeated item
                    $select.html(selectOptions);
                });
            },
            error: function (xhr, status, error) {
                alert('Failed to fetch data: ' + error);
            }
        });
    });

    // Initialize the form repeater
    $('.form-repeater').repeater({
        show: function () {
            // Trigger the data fetch when a new item is added
            $('#ambilDataPesertaBtn').trigger('click');
        },
        hide: function (deleteElement) {
            // if (confirm('Are you sure you want to delete this element?')) {
            //     $(this).slideUp(deleteElement);
            // }
        }
    });
});
</script>
<script>
    $(function () {
  var maxlengthInput = $('.bootstrap-maxlength-example'),
    formRepeater = $('.form-repeater');
  if (maxlengthInput.length) {
    maxlengthInput.each(function () {
      $(this).maxlength({
        warningClass: 'label label-success bg-success text-white',
        limitReachedClass: 'label label-danger',
        separator: ' out of ',
        preText: 'You typed ',
        postText: ' chars available.',
        validate: true,
        threshold: +this.getAttribute('maxlength')
      });
    });
  }
  if (formRepeater.length) {
    var row = 2;
    var col = 1;
    formRepeater.on('submit', function (e) {
      e.preventDefault();
    });
    formRepeater.repeater({
      show: function () {
        var fromControl = $(this).find('.form-control, .form-select');
        var formLabel = $(this).find('.form-label');

        fromControl.each(function (i) {
          var id = 'form-repeater-' + row + '-' + col;
          $(fromControl[i]).attr('id', id);
          $(formLabel[i]).attr('for', id);
          col++;
        });

        row++;

        $(this).slideDown();
      },
      hide: function (e) {
        confirm('Are you sure you want to delete this element?') && $(this).slideUp(e);
      }
    });
  }
});
</script>
@endsection
