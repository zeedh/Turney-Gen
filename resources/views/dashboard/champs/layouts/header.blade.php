<header class="py-3 mb-3 border-bottom sticky-top bg-body-tertiary">
  <div class="container-fluid d-flex align-items-center justify-content-between">
    
    <div>
      <a href="#" class="align-items-center link-body-emphasis text-decoration-none" aria-expanded="false">
        TurneyGen
      </a>
    </div>

    <div class="dropdown">
      <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
      </a>
      <ul class="dropdown-menu dropdown-menu-end text-small shadow">
        <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>
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