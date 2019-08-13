<div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Fact Checkers') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
            </li>
            @auth
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Fake-o-Meter
                    <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ url('category/T') }}"><i class="fas fa-check-circle thrust-rating-t mr-2"></i>Waar</a>
                    <a class="dropdown-item" href="{{ url('category/MT') }}"><i class="fas fa-check-circle thrust-rating-mt mr-2"></i>Grotendeels waar</a>
                    <a class="dropdown-item" href="{{ url('category/HT') }}"><i class="fas fa-check-circle thrust-rating-ht mr-2"></i>Gedeeltelijke waar</a>
                    <a class="dropdown-item" href="{{ url('category/MF') }}"><i class="fas fa-check-circle thrust-rating-mf mr-2"></i>Grotendeels onwaar</a>
                    <a class="dropdown-item" href="{{ url('category/F') }}"><i class="fas fa-check-circle thrust-rating-f mr-2"></i>Onwaar</a>
                    <a class="dropdown-item" href="{{ url('category/Fake') }}"><i class="fas fa-times-circle thrust-rating-fake mr-2"></i>Fake news</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('category/N') }}">Recent</a>
            </li>
            @endauth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('about') }}">Over Ons</a>
            </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registreer</a>
                    </li>
                @endif
            @else
                <li class="nav-item">
                    <span class="d-none d-md-none d-lg-block">
                        <form class="form-inline my-2 my-lg-0" role="search" method="POST" action="{{ url('/search') }}">
                            @csrf
                            <input class="form-control mr-sm-2" name="q" type="search" placeholder="Zoek...">
                            <button class="btn btn-light my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </span>
                    <span class="d-block d-md-block d-lg-none">
                        <a class="nav-link btn btn-default float-left" href="{{ url('search') }}">
                            <i class="fas fa-search"></i>
                        </a>
                    </span>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @if (session()->get('show_gamification') && session()->get('userType') == 'Free_Spirit')
                            @if (session()->get('avatar_path') != null)
                                <img src="{{ asset('storage/' . session()->get('avatar_path')) }}" alt="avatar" class="avatar-navbar">
                            @else
                                <i class="fas fa-user fa-sm"></i>
                            @endif
                        @endif
                        {{ Auth::user()->firstname }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/profile') }}">Profiel</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</div>