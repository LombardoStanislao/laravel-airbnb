<nav class="navbar navbar-expand-md navbar-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img id="logo" src="{{asset('./img/logo.png')}}" alt="">
        </a>
        <div id="header-form">
            <form class="input-menu navbar-search" action="{{ route('search') }}" method="get">
                <input autocomplete="off" v-on:keyup="searchSuggestions"
                type="text" name="location" v-model="query"
                placeholder="Dove vuoi andare?">
                <button type="submit" class="navbar-top-button">
                    <i class="fas fa-search">

                    </i>
                </button>
                <div id="search-form-dropdown" v-if="suggestions.length" v-cloak>
                    <ul>
                        <li v-for="suggestion in suggestions" @click="setQuery(suggestion.place)">
                            <i class="fas" :class="'fa-' + suggestion.type"></i>
                            <span>@{{ suggestion.place }}</span>
                        </li>
                    </ul>
                </div>
            </form>
        </div>


        <div class="collapse navbar-collapse user-menu-container" id="navbarSupportedContent">

            <!-- Right Side Of Navbar -->
            <a class="user-menu" id="user-icon">
                <i class="fas fa-user-circle fa-2x"></i>
            </a>
            @guest
                <span class="ml-2">

                </span>
            @else
                <span class="ml-2">
                    {{ Auth::user()->name }}
                </span>
            @endguest
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
                    <ul>
                        <li>
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
