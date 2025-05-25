<header class="py-3 mb-3 border-bottom sticky-top bg-body-tertiary">
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
      <div class="dropdown">
        <a href="#" class="align-items-center col-lg-4 mb-2 mb-lg-0 link-body-emphasis text-decoration-none" aria-expanded="false" aria-label="Bootstrap menu">
          TurneyGen
        </a>
      </div>

      <div class="d-flex align-items-center">
        <form class="w-100 me-3" role="search">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <div class="flex-shrink-0 dropdown">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="#">New Post</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <!-- <a class="dropdown-item" href="#">Sign out</a> -->
              <form action="/logout" method="post">
                @csrf
                <button type="submit" class="dropdown-item">Logout</a></li></button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>