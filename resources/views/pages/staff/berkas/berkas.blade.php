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
                    <h5 class="text-primary">Welcome {{ Auth::guard('authuser')->user()->staff->nama }}! 🎉</h5>
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
            <div class="col-lg-12 mb-12 col-md-12">
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
                                  <td>
                                    <div class="d-inline-block">
                                        <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end m-0">'
                                        <a target="_blank" href="{{ $data->link_berkas }}"
                                        class="dropdown-item"><i class="ti ti-eye me-1"></i>View
                                    </a>
                                    <button data-bs-toggle="modal"
                                    data-bs-target="#editUser{{ $data->berkas_id }}"
                                    class="dropdown-item"><i class="ti ti-pencil me-1"></i>Edit
                                    </button>
                                        </div>
                                        </div>
                                </td>
                                  @elseif ($data->link_berkas == null)
                                  <td>{{ $data->file_berkas }}</td>
                                  @if ($data->status == 'Diserahkan')
                                  <td> <span class="badge bg-label-warning">{{ $data->status }}</span></td>
                                  @elseif ($data->status == 'Diterima')
                                  <td> <span class="badge bg-label-success">{{ $data->status }}</span></td>
                                  @elseif ($data->status == 'Ditolak')
                                  <td> <span class="badge bg-label-danger">{{ $data->status }}</span></td>
                                  @endif
                                  <td>
                                    <div class="d-inline-block">
                                        <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end m-0">'
                                        <a target="_blank" href="{{ url('storage/store/luaran-berkas/'. $data->file_berkas) }}"
                                        class="dropdown-item"><i class="ti ti-eye me-1"></i>View
                                    </a>
                                    <a href="{{ url('storage/store/luaran-berkas/'. $data->file_berkas) }}" class="dropdown-item" download=""><i class="ti ti-download me-1"></i>Download
                                    </a>
                                    <button data-bs-toggle="modal"
                                    data-bs-target="#editUser{{ $data->berkas_id }}"
                                    class="dropdown-item"><i class="ti ti-pencil me-1"></i>Edit
                                    </button>
                                </div>
                                </div>
                                </td>
                                  @endif
                              </tr>
                              @endforeach
                          @endif
                      </tbody>
                      </table>
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
@endif

 {{-- ==================== EDIT DATA =========================== --}}
 @foreach ($berkas as $data)
 <div class="modal fade" id="editUser{{ $data->berkas_id }}" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-simple modal-edit-user">
     <div class="modal-content p-3 p-md-5">
       <div class="modal-body">
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         <div class="text-center mb-4">
           <h3 class="mb-2">Edit Status Berkas</h3>
         </div>
         <form id="addNewCCForm" class="row g-3" action="{{ route('staff.edit.status.berkas', ['nama' => $kkn->nama, 'periode' => $kkn->periode->nama, 'nim' => request()->route('nim'), 'berkas_id' => $data->berkas_id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-12 col-md-12">
                <label class="form-label" for="status">Status Berkas</label>
                <select id="status" name="status" class="selectpicker w-100" data-style="btn-default">
                    <option value="Diserahkan" @if($data->status === 'Diserahkan') selected="selected" @endif>Diserahkan</option>
                    <option value="Diterima" @if($data->status === 'Diterima') selected="selected" @endif>Diterima</option>
                    <option value="Ditolak" @if($data->status === 'Ditolak') selected="selected" @endif>Ditolak</option>
                </select>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </form>
       </div>
     </div>
   </div>
 </div>
 @endforeach
@endsection
