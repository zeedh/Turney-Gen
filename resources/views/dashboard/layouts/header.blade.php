<header class="py-3 border-bottom sticky-top bg-body-tertiary">
  <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
    
    <!-- Brand / Logo -->
    <div class="dropdown">
      <a href="#" class="align-items-center col-lg-4 mb-2 mb-lg-0 link-body-emphasis text-decoration-none" aria-expanded="false" aria-label="TurneyGen">
        <strong>TurneyGen</strong>
      </a>
    </div>

    <!-- User Dropdown -->
    <div class="flex-shrink-0 dropdown text-end">
      <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="User Avatar" width="32" height="32" class="rounded-circle">
      </a>
      <ul class="dropdown-menu dropdown-menu-end text-small shadow">
        <li><a class="dropdown-item" href="#">New Post</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form action="/logout" method="post">
            @csrf
            <button type="submit" class="dropdown-item">Logout</button>
          </form>
        </li>
      </ul>
    </div>

  </div>
</header>
