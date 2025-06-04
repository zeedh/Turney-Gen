
<div class="d-md-block col-md-3 col-lg-2 bg-body-white border-end p-0">
  <div class="offcanvas-md offcanvas-end bg-body-white" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    
    <div class="offcanvas-header border-bottom px-3 py-2">
      <h5 class="offcanvas-title fw-bold text-primary" id="sidebarMenuLabel">
        🏆 TurneyGen
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
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
