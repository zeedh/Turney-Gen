  <style>
    @media (max-width: 767.98px) {
      .offcanvas-60 {
        width: 60% !important;
        max-width: 60% !important;
      }
    }

  </style>
<div class="d-md-block col-md-3 col-lg-2 bg-body-white border-end p-0">

  <div class="offcanvas-md offcanvas-start offcanvas-60 d-md-flex flex-column p-0 pt-3 overflow-y-auto h-100"
      tabindex="-1"
      id="sidebarMenu"
      aria-labelledby="sidebarMenuLabel">

        <div class="offcanvas-header d-md-none border-bottom">
          <h5 class="offcanvas-title" id="sidebarMenuLabel">Menu Navigasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
      
          <div class="offcanvas-body p-0">
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link text-black d-flex align-items-center gap-2 px-4 py-2 {{ Request::is('champs/competitor*') ? 'active bg-danger text-white' : '' }}"
                  href="{{ route('competitors.index', $champ->id) }}">
                  <svg class="bi"><use xlink:href="#puzzle"/></svg>
                  <span>Peserta</span>
                </a>
              </li>
      
              <li class="nav-item">
                <a class="nav-link text-black d-flex align-items-center gap-2 px-4 py-2 {{ Request::is('champs/edit') ? 'active bg-danger text-white' : '' }}"
                  href="{{ route('champs.edit', $champ->id) }}">
                  <svg class="bi"><use xlink:href="#plus-circle"/></svg>
                  <span>Kategori</span>
                </a>
              </li>
      
              <li class="nav-item">
                <a class="nav-link text-black d-flex align-items-center gap-2 px-4 py-2 {{ Request::is('champs/setting*') ? 'active bg-danger text-white' : '' }}"
                  href="{{ route('setting.index', $champ->id) }}">
                  <svg class="bi"><use xlink:href="#file-earmark"/></svg>
                  <span>Pengaturan</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link text-black d-flex align-items-center gap-2 px-4 py-2 {{ Request::is('champs/setting*') ? 'active bg-danger text-white' : '' }}"
                  href="{{ route('setting.tree.index', ['champ' => $champ->id, 'setting' => $settings->id]) }}">
                  <svg class="bi"><use xlink:href="#file-earmark"/></svg>
                  <span>Tree</span>
                </a>
              </li>
            </ul>
      
            @can('admin')
              <h6 class="sidebar-heading text-muted text-uppercase px-3 mt-4 mb-2 small">Administrator</h6>
              <ul class="nav flex-column mb-2">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2 px-3 py-2 {{ Request::is('dashboard/categories*') ? 'active' : '' }}"
                    href="/dashboard/categories">
                    <svg class="bi"><use xlink:href="#folder"/></svg>
                    <span>Post Categories</span>
                  </a>
                </li>
              </ul>
            @endcan
      
          </div>
        </div>
  </div>
</div>
