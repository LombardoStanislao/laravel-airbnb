{{-- Navbar per mobile --}}

<nav class="navbar-bottom">
    <div class="container">

        <div class="navbar-bottom-link">
            <a href="{{url('/')}}" class="{{ Request::route()->getName() == 'home' ? 'active-link' : ' ' }}">
                <i class="fas fa-home"></i>
                <p>Home</p>
            </a>
        </div>

        @guest
            <div class="navbar-bottom-link">
                <a class=""  href="{{ route('login') }}">
                    <i class="far fa-user"></i>
                    <p>Accedi</p>
                </a>
            </div>


            @if (Route::has('register'))
                <div class="navbar-bottom-link">
                    <a class=""  href="{{ route('register') }}">
                        <i class="far fa-user"></i>
                        <p>Registrati</p>
                    </a>
                </div>

            @endif
        @else
            <a class=""  href="{{ route('admin.index') }}">
                <i class="far fa-user"></i>
                <p>{{ Auth::user()->name }}</p>
            </a>
        @endguest

    </div>
</nav>
