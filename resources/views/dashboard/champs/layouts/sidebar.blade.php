<style>
  .sidebar .nav-link {
    transition: all 0.2s ease-in-out;
    border-left: 4px solid transparent;
    color: #333;
  }

  .sidebar .nav-link:hover {
    background-color: #f8f9fa;
    color: #0d6efd;
  }

  .sidebar .nav-link.active {
    background-color: #e9ecef;
    color: #0d6efd !important;
    font-weight: bold;
    border-left: 4px solid #0d6efd;
  }
</style>

<div class="sidebar border-end col-md-3 col-lg-2 p-0 bg-body-tertiary">
  <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    
    <div class="offcanvas-header border-bottom px-3 py-2">
      <h5 class="offcanvas-title fw-bold text-primary" id="sidebarMenuLabel">
        🏆 TurneyGen
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
      <ul class="nav flex-column mb-3">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 px-3 py-2 {{ Request::is('dashboard/champs/edit/competitors*') ? 'active' : '' }}"
             href="{{ route('competitors.index', $champ->id) }}">
            <svg class="bi"><use xlink:href="#puzzle"/></svg>
            <span>Peserta</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 px-3 py-2 {{ Request::is('dashboard/champs/edit') ? 'active' : '' }}"
             href="{{ route('champs.edit', $champ->id) }}">
            <svg class="bi"><use xlink:href="#plus-circle"/></svg>
            <span>Kategori</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 px-3 py-2 {{ Request::is('dashboard/champs/edit/setting*') ? 'active' : '' }}"
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
