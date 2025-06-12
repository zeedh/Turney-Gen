<header class="py-3 border-bottom sticky-top bg-secondary text-dark">
  <div class="container-fluid d-flex align-items-center justify-content-between" style="grid-template-columns: 1fr 2fr;">

    <button class="btn btn-outline-light d-md-none me-2" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-label="Toggle sidebar">
      <i class="bi bi-list"></i>
    </button>

    <div>
    <a href="/dashboard" class="text-light text-decoration-none fw-bold fs-5">
      TurneyGen
    </a>
    </div>

    <div class="dropdown">
      <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle text-light" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
      </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="/dashboard">
                <i class="bi bi-cast me-1"></i> My Dashboard
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form action="/logout" method="post" class="d-inline">
                @csrf                                
                  <button type="submit" class="dropdown-item">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                  </button>
                </form>
              </li>
          </ul>
    </div>
  </div>
</header>