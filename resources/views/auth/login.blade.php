@extends('layouts.app')

@section('content')
<div class="container-sign-in" id="container-register-signin">
    <div class="forms-container">
        <div class="signin-signup">

            <form method="POST" action="{{ route('login') }}" class="sign-in-form" autocomplete="off">

                @csrf
                <h2 class="title">Accedi</h2>

                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                    placeholder="Inserisci la tua email">

                </div>
                @error('email')
                    <div class="invalid-feedback display-error" role="alert">
                            <strong>{{ $message }}</strong>
                    </div>
                @enderror

                <div class="input-field">
                    <i class="fas fa-lock"></i>

                    <input type="password" class=" @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"
                    placeholder="Inserisci qui la tua password">

                </div>
                @error('password')
                    <div class="invalid-feedback display-error" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

                <div class="">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        Ricordati i miei dati
                    </label>
                </div>

                <div class="">
                    <button type="submit" class="button button-solid">
                        {{ __('Login') }}
                    </button>
                </div>

                <p class="social-text">O accedi tramite le seguenti piattaforme</p>

                <div class="social-media">
                    <a href="#" class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-linkedin"></i>
                    </a>

                </div>


                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Hai dimenticato la password?
                    </a>
                @endif


            </form>

            <form method="POST" action="{{ route('register') }}" class="sign-up-form">

                @csrf
                <h2 class="title">Registrati</h2>

                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                    placeholder="Inserisci il tuo nome">

                </div>
                @error('name')
                    <div class="invalid-feedback display-error" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input id="lastname" type="text" class="@error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname"
                    placeholder="Inserisci il tuo cognome" autofocus>

                </div>
                @error('lastname')
                    <div class="invalid-feedback display-error" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

                <div class="input-field">
                    <i class="fas fa-birthday-cake"></i>


                    <input id="date_of_birth" type="date" class="@error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth" autofocus>

                </div>
                @error('date_of_birth')
                    <div class="invalid-feedback display-error" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"
                    placeholder="Inserisci qui la tua email">

                </div>
                @error('email')
                    <div class="invalid-feedback display-error" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Inserisci qui la password">
                </div>
                @error('password')
                    <div class="invalid-feedback display-error" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input id="password-confirm" type="password" class="" name="password_confirmation" required autocomplete="new-password" placeholder="Conferma la password inserita">
                </div>

                <div class="">
                    <button type="submit" class="button button-solid">
                        {{ __('Registrati') }}
                    </button>
                </div>

                <p class="social-text">O registrati tramite le seguenti piattaforme</p>

                <div class="social-media">
                    <a href="#" class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-linkedin"></i>
                    </a>

                </div>

            </form>



        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>Sei nuovo da queste parti?</h3>
                <p>Non perdere quest'occasione ed iscriviti subito!</p>
                <button type="button"  name="button" class="button button-transparent"
                id="sign-up-button">
                    Registrati
                </button>
            </div>
            <img src="{{ asset('img/Login.svg') }}" alt="login-image" class="image-svg">

        </div>

        <div class="panel right-panel">
            <div class="content">
                <h3>Sei già uno di noi?</h3>
                <p>Accedi subito al tuo profilo!</p>
                <button type="button"  name="button" class="button button-transparent"
                id="sign-in-button">
                    Accedi
                </button>
            </div>
            <img src="{{ asset('img/Register.svg') }}" alt="login-image" class="image-svg">

        </div>
    </div>

</div>
@endsection
