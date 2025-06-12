<header class="py-3 border-bottom sticky-top bg-secondary text-light">
  <div class="container-fluid d-flex align-items-center justify-content-between px-3">

    <!-- Sidebar Toggle (Mobile Only) -->
    <button class="btn btn-outline-light d-md-none me-2" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-label="Toggle sidebar">
      <i class="bi bi-list"></i>
    </button>

    <!-- Brand / Logo -->
    <a href="/dashboard" class="text-light text-decoration-none fw-bold fs-5">
      TurneyGen
    </a>

    <!-- User Dropdown -->
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
        <img src="https://github.com/mdo.png" alt="User Avatar" width="32" height="32" class="rounded-circle border border-light">
      </a>

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-light text-small shadow">
        <li>
          <a class="dropdown-item d-flex align-items-center gap-2" href="/blog">
            <i class="bi bi-house-door-fill text-dark"></i> Halaman Depan
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item d-flex align-items-center gap-2" href="#">
            <i class="bi bi-pencil-square text-dark"></i> New Post
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form action="/logout" method="post" class="m-0">
            @csrf
            <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
              <i class="bi bi-box-arrow-right text-dark"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </div>


  </div>
</header>
