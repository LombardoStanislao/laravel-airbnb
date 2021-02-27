@extends('layouts.app')

@section('content')
<div class="container-sign-in">
    <div class="forms-container">
        <div class="signin-signup">
            <form method="POST" action="{{ route('login') }}" class="sign-in-form" autocomplete="off">

                @csrf
                <h2 class="title">Accedi</h2>

                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                    placeholder="Inserisci la tua email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>


                    

                <div class="input-field">
                    <i class="fas fa-lock"></i>

                    <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"
                    placeholder="Inserisci qui la tua password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

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



        </div>
    </div>

    <div class="panels-container">

    </div>

</div>
@endsection
