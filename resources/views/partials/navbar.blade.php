<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="/">TurneyGen</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Nav -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ $active === 'home' ? 'active fw-semibold' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active === 'blog' ? 'active fw-semibold' : '' }}" href="/blog">Turnamen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $active === 'about' ? 'active fw-semibold' : '' }}" href="/about">About</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link {{ $active === 'categories' ? 'active fw-semibold' : '' }}" href="/categories">Kategori</a>
                </li> -->
            </ul>

            <!-- Right Nav (Auth) -->
            <ul class="navbar-nav mb-2 mb-lg-0">
                @auth
                <li class="nav-item dropdown">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                        <img src="https://github.com/mdo.png" alt="User Avatar" width="32" height="32" class="rounded-circle border border-light mx-2">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @if(auth()->check() && auth()->user()->is_panitia)
                        <li>
                            <a class="dropdown-item" href="/dashboard">
                                <i class="bi bi-cast me-1"></i> My Dashboard
                            </a>
                        </li>
                        @endif
                        <li>
                            <a class="dropdown-item" href="/profile">
                                <i class="bi bi-person-fill me-1"></i> Profile
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
                </li>
                @else
                <li class="nav-item">
                    <a href="/login" class="nav-link {{ $active === 'login' ? 'active fw-semibold' : '' }}">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
