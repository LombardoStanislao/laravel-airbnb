{{-- registrazione e login --}}
<nav class="navbar navbar-expand-md navbar-light shadow-sm navbar-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{asset('./img/logo.png')}}" alt="">
        </a>

        <div class="nav-menu">
            <a class="hover-link" href="{{url('/')}}">
                Appartamenti
            </a>
            <a class="hover-link" href="{{ route('search') }}">
                Ricerca Avanzata
            </a>
        </div>


<<<<<<< HEAD
        <div class="collapse navbar-collapse user-menu-container" id="navbarSupportedContent">
=======
            </ul>
            <div id="header-form">
                <form  class="input-menu" action="{{ route('search') }}" method="get">
                    <input type="text" name="location" value=""  placeholder="Inserisci dove vuoi andare">
                    <button type="submit" class="btn btn-primary ">
                        <i class="fas fa-search">

                        </i>
                    </button>
                </form>
            </div>

>>>>>>> main

            <!-- Right Side Of Navbar -->
            <a class="user-menu" id="user-icon">
                <i class="fas fa-user-circle fa-2x"></i>
            </a>
            <div id="user-dropdown-menu">

                @guest
                    <ul>
                        <li>
                            <a class="" href="{{ route('login') }}">
                                Accedi
                            </a>
                        </li>
                    @if (Route::has('register'))
                        <li>
                            <a class="" href="{{ route('register') }}">
                                Registrati
                            </a>
                        </li>
                    @endif

                    </ul>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="{{ route('admin.index') }}">
                                Area privata
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                            </a>
                        </li>
                    </ul>


                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>

                @endguest
            </div>
        </div>
    </div>
</nav>
<<<<<<< HEAD

{{-- Navbar per mobile --}}

<nav class="navbar-bottom">
    <div class="container">

        <div class="navbar-bottom-link">
            <a href="{{url('/')}}" class="{{ Request::route()->getName() == 'home' ? 'active-link' : ' ' }}">
                <i class="fas fa-search"></i>
                <p>Esplora</p>
            </a>
        </div>

        <div class="navbar-bottom-link">
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


    </div>
=======
<script type="text/javascript">
window.addEventListener("scroll",function(){
    var header = document.querySelector("header");
    var form = document.querySelector("form");
    header.classList.toggle("sticky", window.scrollY > 0);
    form.classList.toggle("sticky", window.scrollY > 0);
});
</script>
{{-- ricerca --}}
<nav>
    {{-- input --}}
>>>>>>> main
</nav>
