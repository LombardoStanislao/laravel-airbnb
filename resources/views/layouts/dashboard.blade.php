<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" charset="utf-8" defer></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark flex-md-nowrap p-0">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Airbnb</a>
            <ul class="navbar-nav px-3 ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        Visita il sito
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 bg-light sidebar py-4">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <h5>
                                <a class="nav-link active" href="{{ route('admin.index') }}">
                                    Home Dashboard
                                </a>
                            </h5>
                        </li>
                        <li class="nav-item">
                            <h5>
                                <a class="nav-link" href="{{ route('admin.apartments.index') }}">
                                    I tuoi appartamenti
                                </a>
                            </h5>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Scripts --}}
    @yield('scripts')
</body>
</html>
