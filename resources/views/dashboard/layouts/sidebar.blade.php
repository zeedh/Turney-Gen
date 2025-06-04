<!-- SIDEBAR CONTAINER -->
<div class="d-md-block col-md-3 col-lg-2 bg-body-tertiary border-end p-0">
  <!-- MOBILE COLLAPSIBLE SIDEBAR -->
  <div class="offcanvas-md offcanvas-start d-md-flex flex-column p-0 pt-3 overflow-y-auto h-100" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header d-md-none">
      <h5 class="offcanvas-title" id="sidebarMenuLabel">Menu</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-0">
      <ul class="nav flex-column mb-2">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 px-4 py-2 {{ Request::is('dashboard') ? 'active bg-primary text-white' : '' }}" href="/dashboard">
            <i class="bi bi-house-fill"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 px-4 py-2 {{ Request::is('dashboard/tours*') ? 'active bg-primary text-white' : '' }}" href="/dashboard/tours">
            <i class="bi bi-puzzle"></i> Turnamen
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 px-4 py-2 {{ Request::is('dashboard/champs*') ? 'active bg-primary text-white' : '' }}" href="/dashboard/champs">
            <i class="bi bi-diagram-3-fill"></i> Bagan Pertandingan
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 px-4 py-2 {{ Request::is('dashboard/posts*') ? 'active bg-primary text-white' : '' }}" href="/dashboard/posts">
            <i class="bi bi-file-earmark-text"></i> Postingan
          </a>
        </li>
      </ul>

      @can('admin')
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center text-muted px-4 mt-4 mb-1">
        <span>Administrator</span>
      </h6>
      <ul class="nav flex-column mb-2">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 px-4 py-2 {{ Request::is('dashboard/categories*') ? 'active bg-primary text-white' : '' }}" href="/dashboard/categories">
            <i class="bi bi-tags-fill"></i> Post Categories
          </a>
        </li>
      </ul>
      @endcan
    </div>
  </div>
</div>
