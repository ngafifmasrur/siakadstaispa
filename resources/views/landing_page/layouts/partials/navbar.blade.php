<!--Navbar Start-->
<nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark" id="navbar">
    <div class="container">
        <!-- LOGO -->
        <a class="navbar-brand logo" href="{{ url('/home') }}">
            <img src="{{ asset('landing_page/images/logo_text.webp') }}" alt="" height="30">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto navbar-center" id="navbar-navlist">
                @foreach ($menus as $item)
                <li class="nav-item <?php if('/'.request()->path() == $item->link){ echo "active"; } ?>">
                    <a href="{{ $item->link }}" class="nav-link">{{ $item->judul }}</a>
                </li>
                @endforeach
                <li class="nav-item">
                    @auth
                    <a href="{{ route(auth()->user()->role->name.'.dashboard') }}"" class="nav-link">Dashboard</a>
                    @else
                        <a href="{{ url('/login') }}"" class="nav-link">Login</a>
                    @endauth
                </li>
            </ul>

        </div>
    </div>
</nav>
<!-- Navbar End -->
