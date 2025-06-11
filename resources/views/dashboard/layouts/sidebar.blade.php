  <style>
    @media (max-width: 767.98px) {
      .offcanvas-60 {
        width: 60% !important;
        max-width: 60% !important;
      }
    }

  </style>
  <div class="d-md-block col-md-3 col-lg-2 bg-white border-end p-0">

  <!-- MOBILE COLLAPSIBLE SIDEBAR -->
  <div class="offcanvas-md offcanvas-start offcanvas-60 d-md-flex flex-column p-0 pt-3 overflow-y-auto h-100"
      tabindex="-1"
      id="sidebarMenu"
      aria-labelledby="sidebarMenuLabel">
    
    <!-- Mobile Header -->
    <div class="offcanvas-header d-md-none border-bottom">
      <h5 class="offcanvas-title" id="sidebarMenuLabel">Menu Navigasi</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Sidebar Body -->
    <div class="offcanvas-body p-0">
      <ul class="nav flex-column mb-2">

        <li class="nav-item action">
          <a class="nav-link px-4 py-2 d-flex align-items-center gap-2 {{ Request::is('dashboard') ? 'active bg-primary text-white' : 'text-dark' }}" href="/dashboard">
            <i class="bi bi-house-fill text-warning"></i> Dashboard
          </a>
        </li>

        <li class="nav-item action">
          <a class="nav-link px-4 py-2 d-flex align-items-center gap-2 {{ Request::is('dashboard/tours*') ? 'active bg-primary text-white' : 'text-dark' }}" href="/dashboard/tours">
            <i class="bi bi-puzzle-fill text-danger"></i> Turnamen
          </a>
        </li>

        <li class="nav-item action">
          <a class="nav-link px-4 py-2 d-flex align-items-center gap-2 {{ Request::is('dashboard/champs*') ? 'active bg-primary text-white' : 'text-dark' }}" href="/dashboard/champs">
            <i class="bi bi-diagram-3-fill text-success"></i> Bagan Pertandingan
          </a>
        </li>

        <li class="nav-item action">
          <a class="nav-link px-4 py-2 d-flex align-items-center gap-2 {{ Request::is('dashboard/posts*') ? 'active bg-primary text-white' : 'text-dark' }}" href="/dashboard/posts">
            <i class="bi bi-file-text-fill text-info"></i> Postingan
          </a>
        </li>
      </ul>

      <!-- Admin Only -->
      @can('admin')
      <hr class="my-2">
      <div class="px-4 text-muted small text-uppercase fw-bold mt-3 mb-1">Administrator</div>
      <ul class="nav flex-column mb-2">
        <li class="nav-item action">
          <a class="nav-link px-4 py-2 d-flex align-items-center gap-2 {{ Request::is('dashboard/categories*') ? 'active bg-warning text-white' : 'text-dark' }}" href="/dashboard/categories">
            <i class="bi bi-tags-fill text-warning"></i> Post Categories
          </a>
        </li>
      </ul>
      @endcan
    </div>
  </div>
</div>
