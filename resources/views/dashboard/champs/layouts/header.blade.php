<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top border-bottom py-2">
  <div class="container py-1">

    <!-- Sidebar Toggle (Mobile Only) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-label="Toggle sidebar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Logo -->
    <a href="/dashboard" class="text-light text-decoration-none fw-bold fs-5">
      TurneyGen
    </a>

    <!-- User Dropdown -->
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                        @if(auth()->user()->image)
                            <img src="{{ auth()->user()->image ? url('/profile-image/' . basename(auth()->user()->image)) : asset('default-profile.png') }}"
                                alt="User Avatar" 
                                width="32" height="32" 
                                class="rounded-circle border border-light mx-2">
                        @else
                            <i class="bi bi-person-circle fs-4 mx-3 mb-4"></i>
                        @endif
                        {{ auth()->user()->name }}
      </a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-light text-small shadow me-auto mb-2 mb-lg-0">
        <li>
          <a class="dropdown-item d-flex align-items-center gap-2" href="/dashboard">
            <i class="bi bi-cast me-1"></i> My Dashboard
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
</nav>
