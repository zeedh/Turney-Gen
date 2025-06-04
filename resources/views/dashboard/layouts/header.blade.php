<header class="py-3 border-bottom sticky-top bg-danger text-light">
  <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">

    <!-- Brand / Logo -->
    <div>
      <a href="#" class="d-flex align-items-center text-decoration-none text-light fw-bold" aria-label="TurneyGen">
        TurneyGen
      </a>
    </div>

    <!-- User Dropdown -->
    <div class="flex-shrink-0 dropdown text-end">
      <a href="#" class="d-block text-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
        <img src="https://github.com/mdo.png" alt="User Avatar" width="32" height="32" class="rounded-circle border border-light">
      </a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark text-small shadow">
        <li><a class="dropdown-item" href="#">New Post</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form action="/logout" method="post" class="m-0 p-0">
            @csrf
            <button type="submit" class="dropdown-item">Logout</button>
          </form>
        </li>
      </ul>
    </div>

  </div>
</header>

