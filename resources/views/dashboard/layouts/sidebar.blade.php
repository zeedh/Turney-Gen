  <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">TurneyGen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
              <svg class="bi" aria-hidden="true"><use xlink:href="#house-fill"/></svg>
              Dashboard
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 {{ Request::is('dashboard/tours*') ? 'active' : '' }}" href="/dashboard/tours">
              <svg class="bi" aria-hidden="true"><use xlink:href="#puzzle"/></svg>
              Turnamen
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 {{ Request::is('dashboard/champs*') ? 'active' : '' }}" href="/dashboard/champs">
              <svg class="bi" aria-hidden="true"><use xlink:href="#plus-circle"/></svg>
              Bagan Pertandingan
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 {{ Request::is('dashboard/posts*') ? 'active' : '' }}" href="/dashboard/posts">
              <svg class="bi" aria-hidden="true"><use xlink:href="#file-earmark"/></svg>
              Postingan
            </a>
          </li>
        </ul>

        @can('admin')
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Administrator </span>
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
              <a class="nav-link d-flex align-items-center gap-2 {{ Request::is('dashboard/categories*') ? 'active' : '' }}" href="/dashboard/categories">
                <svg class="bi" aria-hidden="true"><use xlink:href="#file-earmark"/></svg>
                Post Categories
              </a>
          </li>

        </ul>
        @endcan

      </div>
    </div>
  </div>