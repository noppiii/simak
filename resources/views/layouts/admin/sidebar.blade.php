@if(Auth::guard('authuser')->user()->role->role_name === "Admin")
 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">
          <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
              fill="#7367F0"
            />
            <path
              opacity="0.06"
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
              fill="#161616"
            />
            <path
              opacity="0.06"
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
              fill="#161616"
            />
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
              fill="#7367F0"
            />
          </svg>
        </span>
        <span class="app-brand-text demo menu-text fw-bold">Vuexy</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item {{ request()->is('admin/dashboard*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div data-i18n="Dashboards">Dashboards</div>
          <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->is('admin/dashboard-pendaftaran*') ? 'active' : '' }}">
            <a href="{{ route('admin-dashboard-pendaftaran') }}" class="menu-link">
              <div>Analytics Pendaftaran</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('admin/dashboard-penilaian*') ? 'active' : '' }}">
            <a href="{{ route('admin-dashboard-penilaian') }}" class="menu-link">
              <div>Analytics Penilaian</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('admin/dashboard-berkas*') ? 'active' : '' }}">
            <a href="{{ route('admin-dashboard-berkas') }}" class="menu-link">
              <div>Analytics Berkas</div>
            </a>
          </li>
        </ul>
      </li>


      <!-- Apps & Pages -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Master User</span>
      </li>
      <li class="menu-item {{ request()->is('admin/admin*') ? 'active' : '' }}">
        <a href="{{ route('admin.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-user"></i>
          <div>Admin</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('admin/staff*') ? 'active' : '' }}">
        <a href="{{ route('staff.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-user-plus"></i>
          <div>Staff</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('admin/pimpinan*') ? 'active' : '' }}">
        <a href="{{ route('pimpinan.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-user-check"></i>
          <div>Pimpinan</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('admin/dpl*') ? 'active' : '' }}">
        <a href="{{ route('dpl.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-user-exclamation"></i>
          <div>DPL</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('admin/mahasiswa*') ? 'active' : '' }}">
        <a href="{{ route('mahasiswa.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-users"></i>
          <div>Mahasiswa</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Master KKN</span>
      </li>
      <li class="menu-item {{ request()->is('admin/kkn*') ? 'active' : '' }}">
        <a href="{{ route('kkn.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-color-swatch"></i>
          <div>KKN</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('admin/list-kkn*') ? 'active' : '' }}">
        <a href="{{ route('list.kkn.mhs') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-id"></i>
          <div>KKN Mahasiswa</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('admin/penataan*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-settings-automation"></i>
          <div>Penataan KKN</div>
          <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->is('admin/penataan-periode*') ? 'active' : '' }}">
                <a href="{{ route('penataan-periode.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons ti ti-calendar-event"></i>
                  <div>Periode</div>
                </a>
              </li>
          <li class="menu-item {{ request()->is('admin/penataan-skema*') ? 'active' : '' }}">
            <a href="{{ route('penataan-skema.index') }}" class="menu-link">
              <div>Skema</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('admin/penataan-persyaratan*') ? 'active' : '' }}">
            <a href="{{ route('penataan-persyaratan.index') }}" class="menu-link">
              <div>Persyaratan</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item {{ request()->is('admin/wilayah*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-map-pin"></i>
          <div>Wilayah</div>
          <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->is('admin/wilayah-desa*') ? 'active' : '' }}">
            <a href="{{ route('wilayah-desa.index') }}" class="menu-link">
              <div>Desa</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('admin/wilayah-kecamatan*') ? 'active' : '' }}">
            <a href="{{ route('wilayah-kecamatan.index') }}" class="menu-link">
              <div>Kecamatan</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('admin/wilayah-kabupaten*') ? 'active' : '' }}">
            <a href="{{ route('wilayah-kabupaten.index') }}" class="menu-link">
              <div>Kabupaten</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Master Akademik</span>
      </li>
      <li class="menu-item {{ request()->is('admin/fakultas*') ? 'active' : '' }}">
        <a href="{{ route('fakultas.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-building-arch"></i>
          <div>Fakultas</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('admin/program-studi*') ? 'active' : '' }}">
        <a href="{{ route('program-studi.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-building-fortress"></i>
          <div>Program Studi</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Manage Dokumen</span>
      </li>
      <li class="menu-item {{ request()->is('admin/list-berkas*') ? 'active' : '' }}">
        <a href="{{ route('list.berkas.kkn') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-file-description"></i>
          <div>Berkas KKN</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('admin/list-sertifikat*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-certificate"></i>
          <div>Sertifikat KKN</div>
          <div class="badge bg-label-primary rounded-pill ms-auto">2</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->is('admin/list-sertifikat-mahasiswa*') ? 'active' : '' }}">
            <a href="{{ route('list.sertifikat.kkn') }}" class="menu-link">
              <div>Sertifikat Mahasiswa</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('admin/dashboard-penilaian*') ? 'active' : '' }}">
            <a href="{{ route('admin-dashboard-penilaian') }}" class="menu-link">
              <div>Template Sertifikat</div>
            </a>
          </li>
        </ul>
      </li>
    </ul>
 </aside>
@elseif(Auth::guard('authuser')->user()->role->role_name === "Staff")
 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
          <span class="app-brand-logo demo">
            <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                fill="#7367F0"
              />
              <path
                opacity="0.06"
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                fill="#161616"
              />
              <path
                opacity="0.06"
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                fill="#161616"
              />
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                fill="#7367F0"
              />
            </svg>
          </span>
          <span class="app-brand-text demo menu-text fw-bold">Vuexy</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
          <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
          <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
      </div>

      <div class="menu-inner-shadow"></div>

      <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ request()->is('staff/dashboard*') ? 'open active' : '' }}">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Dashboards">Dashboards</div>
            <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item {{ request()->is('staff/dashboard-pendaftaran*') ? 'active' : '' }}">
              <a href="{{ route('staff-dashboard-pendaftaran') }}" class="menu-link">
                <div>Analytics Pendaftaran</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('staff/dashboard-penilaian*') ? 'active' : '' }}">
              <a href="{{ route('staff-dashboard-penilaian') }}" class="menu-link">
                <div>Analytics Penilaian</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('staff/dashboard-berkas*') ? 'active' : '' }}">
              <a href="{{ route('staff-dashboard-berkas') }}" class="menu-link">
                <div>Analytics Berkas</div>
              </a>
            </li>
          </ul>
        </li>

        <li class="menu-header small text-uppercase">
          <span class="menu-header-text">Master KKN</span>
        </li>
        <li class="menu-item {{ request()->is('staff/kuliah-kerja-nyata*') ? 'active' : '' }}">
          <a href="{{ route('kuliah-kerja-nyata.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-color-swatch"></i>
            <div>KKN</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('staff/list-kkn*') ? 'active' : '' }}">
          <a href="{{ route('staff.list.kkn.mhs') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-id"></i>
            <div>KKN Mahasiswa</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('staff/pengaturan*') ? 'open active' : '' }}">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-settings-automation"></i>
            <div>Penataan KKN</div>
            <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
          </a>
          <ul class="menu-sub">
              <li class="menu-item {{ request()->is('staff/pengaturan-periode*') ? 'active' : '' }}">
                  <a href="{{ route('pengaturan-periode.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-calendar-event"></i>
                    <div>Periode</div>
                  </a>
                </li>
            <li class="menu-item {{ request()->is('staff/pengaturan-skema*') ? 'active' : '' }}">
              <a href="{{ route('pengaturan-skema.index') }}" class="menu-link">
                <div>Skema</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('staff/pengaturan-persyaratan*') ? 'active' : '' }}">
              <a href="{{ route('pengaturan-persyaratan.index') }}" class="menu-link">
                <div>Persyaratan</div>
              </a>
            </li>
          </ul>
        </li>
        <li class="menu-item {{ request()->is('staff/daerah*') ? 'open active' : '' }}">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-map-pin"></i>
            <div>Wilayah</div>
            <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item {{ request()->is('staff/daerah-desa*') ? 'active' : '' }}">
              <a href="{{ route('daerah-desa.index') }}" class="menu-link">
                <div>Desa</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('staff/daerah-kecamatan*') ? 'active' : '' }}">
              <a href="{{ route('daerah-kecamatan.index') }}" class="menu-link">
                <div>Kecamatan</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('staff/daerah-kabupaten*') ? 'active' : '' }}">
              <a href="{{ route('daerah-kabupaten.index') }}" class="menu-link">
                <div>Kabupaten</div>
              </a>
            </li>
          </ul>
        </li>

        <li class="menu-header small text-uppercase">
          <span class="menu-header-text">Manage Dokumen</span>
        </li>
        <li class="menu-item {{ request()->is('staff/list-berkas*') ? 'active' : '' }}">
          <a href="{{ route('staff.list.berkas.kkn') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-file-description"></i>
            <div>Berkas KKN</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('staff/program-studi*') ? 'active' : '' }}">
          <a href="{{ route('program-studi.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-certificate"></i>
            <div>Sertifikat KKN</div>
          </a>
        </li>
      </ul>
    </aside>

@elseif(Auth::guard('authuser')->user()->role->role_name === "Pimpinan")
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
              <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                  fill="#7367F0"
                />
                <path
                  opacity="0.06"
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                  fill="#161616"
                />
                <path
                  opacity="0.06"
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                  fill="#161616"
                />
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                  fill="#7367F0"
                />
              </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bold">Vuexy</span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
          <!-- Dashboards -->
          <li class="menu-item {{ request()->is('pimpinan/dashboard*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons ti ti-smart-home"></i>
              <div data-i18n="Dashboards">Dashboards</div>
              <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item {{ request()->is('pimpinan/dashboard-pendaftaran*') ? 'active' : '' }}">
                <a href="{{ route('pimpinan-dashboard-pendaftaran') }}" class="menu-link">
                  <div>Analytics Pendaftaran</div>
                </a>
              </li>
              <li class="menu-item {{ request()->is('pimpinan/dashboard-penilaian*') ? 'active' : '' }}">
                <a href="{{ route('pimpinan-dashboard-penilaian') }}" class="menu-link">
                  <div>Analytics Penilaian</div>
                </a>
              </li>
              <li class="menu-item {{ request()->is('pimpinan/dashboard-berkas*') ? 'active' : '' }}">
                <a href="{{ route('pimpinan-dashboard-berkas') }}" class="menu-link">
                  <div>Analytics Berkas</div>
                </a>
              </li>
            </ul>
          </li>


          <!-- Apps & Pages -->
          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Transkip Berkas</span>
          </li>
          <li class="menu-item {{ request()->is('admin/admin*') ? 'active' : '' }}">
            <a href="{{ route('admin.index') }}" class="menu-link">
              <i class="menu-icon tf-icons ti ti-file"></i>
              <div>Luaran Mahasiswa</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('admin/admin*') ? 'active' : '' }}">
            <a href="{{ route('admin.index') }}" class="menu-link">
              <i class="menu-icon tf-icons ti ti-file-description"></i>
              <div>Surat Edaran</div>
            </a>
          </li>
        </ul>
      </aside>


@elseif(Auth::guard('authuser')->user()->role->role_name === "Dosen")
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">
          <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
              fill="#7367F0"
            />
            <path
              opacity="0.06"
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
              fill="#161616"
            />
            <path
              opacity="0.06"
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
              fill="#161616"
            />
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
              fill="#7367F0"
            />
          </svg>
        </span>
        <span class="app-brand-text demo menu-text fw-bold">Vuexy</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item {{ request()->is('dosen/dashboard*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div data-i18n="Dashboards">Dashboards</div>
          <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->is('dosen/dashboard-penilaian*') ? 'active' : '' }}">
            <a href="{{ route('dosen-dashboard-penilaian') }}" class="menu-link">
              <div>Analytics Penilaian</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('dosen/dashboard-peserta*') ? 'active' : '' }}">
            <a href="{{ route('dosen-dashboard-peserta') }}" class="menu-link">
              <div>Analytics Peserta</div>
            </a>
          </li>
        </ul>
      </li>


      <!-- Apps & Pages -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Master Penilaian</span>
      </li>
      <li class="menu-item {{ request()->is('dosen/list-kkn*') ? 'active' : '' }}">
        <a href="{{ route('dosen.list.kkn.mhs') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-user"></i>
          <div>Penilaian</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('admin/admin*') ? 'active' : '' }}">
        <a href="{{ route('admin.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-align-center"></i>
          <div>Kriteria</div>
        </a>
      </li>
      <!-- Apps & Pages -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Manage Laporan</span>
      </li>
      <li class="menu-item {{ request()->is('admin/admin*') ? 'active' : '' }}">
        <a href="{{ route('admin.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-file-pencil"></i>
          <div>Rekap Nilai</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('admin/admin*') ? 'active' : '' }}">
        <a href="{{ route('admin.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-checklist"></i>
          <div>Laporan</div>
        </a>
      </li>
    </ul>
  </aside>

@elseif(Auth::guard('authuser')->user()->role->role_name === "Mahasiswa")
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">
          <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
              fill="#7367F0"
            />
            <path
              opacity="0.06"
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
              fill="#161616"
            />
            <path
              opacity="0.06"
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
              fill="#161616"
            />
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
              fill="#7367F0"
            />
          </svg>
        </span>
        <span class="app-brand-text demo menu-text fw-bold">Vuexy</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <li class="menu-item {{ request()->is('mahasiswa/dashboard*') ? 'active' : '' }}">
        <a href="{{ route('mahasiswa-dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div>Dashboard</div>
        </a>
      </li>
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Informasi KKN</span>
      </li>
      <li class="menu-item {{ request()->is('mahasiswa/daftar*') ? 'active' : '' }}">
        <a href="{{ route('daftar-kkn.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-color-swatch"></i>
          <div>KKN</div>
        </a>
      </li>
      @if (Auth::guard('authuser')->user()->mahasiswa->kknMahasiswa !== null)
      <li class="menu-item {{ request()->is('mahasiswa/luaran*') ? 'active' : '' }}">
        <a href="{{ route('luaran.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-clipboard-text"></i>
          <div>Luaran</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('mahasiswa/sertifikat-mahasiswa*') ? 'active' : '' }}">
        <a href="{{ route('sertifikat-mahasiswa.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-certificate-2"></i>
          <div>Sertifikat</div>
        </a>
      </li>
      @endif
    </ul>
  </aside>
@endif
