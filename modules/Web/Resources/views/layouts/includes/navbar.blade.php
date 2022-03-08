<nav class="navbar navbar-expand-md navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand py-2" href="{{ url('/') }}">
            <img src="{{ asset('assets/img/logo/icon-rn32.png') }}" width="24" height="24" alt="" style="margin-top: -5px;" class="mr-1">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm py-0 py-md-2 sticky-top">
    <div class="container">
        <div class="collapse navbar-collapse py-2 py-md-0" id="navbar">
            <ul class="navbar-nav mr-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link pl-0" href="{{ route('account.login', ['next' => url()->current()]) }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-success" href="{{ route('account.register', ['next' => url()->current()]) }}">Daftar</a>
                    </li>
                @else
                    @include('account::includes.logout')
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link pl-0 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ auth()->user()->profile->name ?? auth()->user()->username }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-left mb-3" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('account.home') }}"> Akun saya </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('account.user.password', ['next' => url()->current()]) }}"> Ubah sandi </a>
                            <a class="dropdown-item" href="#" onclick="$('#logout-form').submit();"> Logout </a>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>