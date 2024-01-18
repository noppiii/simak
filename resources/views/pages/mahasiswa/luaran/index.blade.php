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
          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- DataTable with Buttons -->
            <div class="card">
              <div class="card-datatable table-responsive pt-0">
                <table class="datatables-luaran table">
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                      <th>ID</th>
                      <th>Luaran</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1; ?>
                    @if(isset($berkas) && $berkas->count() > 0)
                        @foreach($berkas as $data)
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $data->berkas_id }}</td>
                            @if ($data->file_berkas == null && $data->link_berkas == null)
                                <td><p class="text-danger">Belum mengajukan luaran apapun</p></td>
                            @elseif ($data->file_berkas == null)
                            <td>{{ Str::limit($data->link_berkas, 30) }}</td>
                            @if ($data->status == 'Diserahkan')
                            <td> <span class="badge bg-label-warning">{{ $data->status }}</span></td>
                            @elseif ($data->status == 'Diterima')
                            <td> <span class="badge bg-label-success">{{ $data->status }}</span></td>
                            @elseif ($data->status == 'Ditolak')
                            <td> <span class="badge bg-label-danger">{{ $data->status }}</span></td>
                            @endif
                            @elseif ($data->link_berkas == null)
                            <td>{{ $data->file_berkas }}</td>
                            @if ($data->status == 'Diserahkan')
                            <td> <span class="badge bg-label-warning">{{ $data->status }}</span></td>
                            @elseif ($data->status == 'Diterima')
                            <td> <span class="badge bg-label-success">{{ $data->status }}</span></td>
                            @elseif ($data->status == 'Ditolak')
                            <td> <span class="badge bg-label-danger">{{ $data->status }}</span></td>
                            @endif
                            @endif
                            <td>
                                <div class="d-inline-block">
                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end m-0">'
                                    <button data-bs-toggle="modal"
                                    data-bs-target="#viewUser{{ $data->berkas_id }}"
                                    class="dropdown-item"><i class="ti ti-eye me-1"></i>View
                                </button>
                                <a href="{{ route('luaran.edit', $data->berkas_id) }}" class="dropdown-item"><i class="ti ti-pencil me-1"></i>Edit
                                </a>
                                    </div>
                                    </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                </table>
              </div>
            </div>
        </div>
        </div>
  </div>

  {{-- ============= SHOW DATA =============== --}}
  @if(isset($berkas) && $berkas->count() > 0)
  @foreach ($berkas as $data)
      <div class="modal fade" id="viewUser{{ $data->berkas_id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-simple modal-edit-user">
              <div class="modal-content p-3 p-md-5">
                  <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-4">
                          <h3 class="mb-2">Informasi Luaran</h3>
                          <p class="text-muted">Informasi tentang yang Anda Ajukan.</p>
                      </div>
                      <form id="editUserForm" class="row g-3" onsubmit="return false">
                          @if ($data->file_berkas == null)
                              <div class="col-12 col-md-12">
                                  <label class="form-label me-2" for="modalEditUserName">Link URL : </label>
                                  <a href="{{ $data->link_berkas }}" target="_blank"><i class="ti ti-link"></i> {{ Str::limit($data->link_berkas, 60) }} </a>
                              </div>
                          @elseif ($data->link_berkas == null)
                              <div class="col-12 col-md-12">
                                  <label class="form-label me-2" for="modalEditUserName">File Berkas :</label>
                                  <a target="_blank" href="{{ url('storage/store/luaran-berkas/'. $data->file_berkas) }}"><i class="ti ti-file"></i> {{ $data->file_berkas }}</a>
                              </div>
                          @endif
                          <div class="col-12 text-center">
                              <button type="reset" data-bs-dismiss="modal" aria-label="Close" class="btn btn-primary me-sm-3 me-1">Close</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  @endforeach
@else
  <p class="text-center">Tidak ada data luaran yang ditemukan.</p>
@endif
@endsection
