<nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">FINESSER</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop') }}">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3 w-100 justify-content-end">
                <!-- Modern Search Bar -->
                <div class="search-container flex-grow-1 position-relative" style="max-width: 420px;">
                    <form action="{{ route('search') }}" method="GET" class="search-form position-relative">
                        <input type="text" 
                               class="form-control search-input ps-4 pe-5 fw-semibold" 
                               id="search-input" 
                               name="q"
                               placeholder="Cari produk, kategori, atau tag..." 
                               autocomplete="off"
                               value="{{ request('q') }}"
                               style="height: 48px; font-size: 1.08rem;">
                        <button type="submit" class="btn search-btn position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0 bg-transparent" style="z-index:2;">
                            <i class="fas fa-search fa-lg text-secondary"></i>
                        </button>
                    </form>
                    <div id="search-suggestions" class="search-suggestions"></div>
                    <div id="search-results" class="search-results"></div>
                </div>

                <!-- User Dropdown -->
                <div class="dropdown ms-2">
                    <button class="btn btn-outline-dark rounded-circle p-2 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="dropdown" style="width:38px; height:38px;">
                        <i class="fas fa-user fa-lg"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item py-2" href="{{ url('/admin') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                            @endif
                            <li><a class="dropdown-item py-2" href="{{ route('profile.show') }}">
                                <i class="fas fa-user-edit me-2"></i>Profile
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            <li><a class="dropdown-item py-2" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Include Advanced Search CSS and JS -->
<link rel="stylesheet" href="{{ asset('css/advanced-search.css') }}">
<script src="{{ asset('js/advanced-search.js') }}"></script>