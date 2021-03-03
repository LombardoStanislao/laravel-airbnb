@extends('layouts.app')

@section('scripts')
    <script type="text/javascript" defer>
        var noSponsoredApartments = "{{ $sponsored_apartments->isEmpty() }}";
    </script>
@endsection

@section('header')
    <header id="header-guest">
        @include('guest.partials.navbar-top')

        <section id="jumbotron-homepage">
            <div class="container">
                <div class="row">
                    <div class="offset-xl-6 col-xl-6 col-lg-8 offset-lg-2 text-center">
                        <div class="jumbo-container">
                            <img id="logo-jumbo" src="{{asset('img/logo-jumbo.png')}}" alt="">
                            <h1 id="jumbo-title">Benvenuto su Airbnb</h1>
                            <p class="jumbo-text">Hai una camera o un appartamento che non utilizzi? Condivili con noi e guadagna facendo nuove esperienze.
                            <br> Registrati subito!  </p>
                            <a href="{{ route('register') }}" class="button button-solid">
                                {{ __('Registrati') }}
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </section>

    </header>
@endsection

@section('content')
    <main id="main-home">
        <div id="home" class="container">

            {{-- Card di prova --}}
            {{-- <div class="row">
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-5">
                    <a href="#">
                        <div class="card-apartment-container">
                            <div class="card-apartment-image">
                                <img src="{{asset("img/prova.jpg")}} " alt="Immagine dell'appartamento" class="img-fluid">
                                <span class="card-apartment-city">Milano</span>
                            </div>
                            <div class="card-apartment-description">
                                <h2 class="card-apartment-header text-center">Titolo dell'appartamento ancora più lungo</h2>
                                <p class="text-center">
                                    <i class="fas fa-euro-sign"></i>
                                    <span>Prezzo per notte: 65€</span>
                                </p>

                            </div>

                        </div>
                    </a>
                </div>

            </div> --}}

            <div class="row">
                <div class="col-12">
                    @if (!$sponsored_apartments->isEmpty())
                        <h1>Appartamenti in evidenza</h1>
                    @endif
                </div>
                @foreach ($sponsored_apartments as $apartment)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-5">
                        <a id="sponsored-apartment-card" href="{{ route('guest.apartment-show', ['slug' => $apartment->slug])}}">
                            <div class="card-apartment-container">
                                <div class="card-apartment-image">
                                    <img src="{{asset("img/prova.jpg")}} " alt="Immagine dell'appartamento" class="img-fluid">
                                    <span class="card-apartment-city">Milano</span>
                                </div>
                                <div class="card-apartment-description">
                                    {{-- <span class="card-apartment-city">Milano</span> --}}
                                    <h2 class="card-apartment-header text-center">{{$apartment->title}}</h2>
                                    <p class="text-center">
                                        <i class="fas fa-euro-sign"></i>
                                        <span>Prezzo per notte: 65€</span>
                                    </p>

                                </div>

                            </div>
                        </a>
                    </div>
                    {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-5">
                        <a id="sponsored-apartment-card" href="{{ route('guest.apartments.show', ['slug' => $apartment->slug]) }}" class="card h-100 m-3">
                            <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="mw-100">
                            <div  class="card-body">
                                <h5 class="card-title">Id: {{$apartment->id}}</h5>
                                <p class="card-text">{{ $apartment->title }}</p>
                                <p class="card-text">Sponsorizzazione attiva: {{ isSponsored($apartment) ? 'Sì' : 'No' }}</p>
                            </div>
                        </a>
                    </div> --}}
                @endforeach
            </div>

            <div class="row">
                <div class="col-12">
                    @if (!$sponsored_apartments->isEmpty() && !$non_sponsored_apartments->isEmpty())
                        <button @click="showMore ? showMore = false : showMore = true" class="btn btn-success">Mostra altri appartamenti</button>
                    @endif
                </div>

                <div class="col-12" v-if="showMore || noSponsoredApartments">
                    <div class="row">
                        @foreach ($non_sponsored_apartments as $apartment)

                            <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-5">
                                <a id="sponsored-apartment-card" href="{{ route('guest.apartments.show', ['slug' => $apartment->slug]) }}">
                                    <div class="card-apartment-container">
                                        <div class="card-apartment-image">
                                            <img src="{{ asset("storage/" . $apartment->{"main-image"}) }} " alt="Immagine dell'appartamento" class="img-fluid">
                                            <span class="card-apartment-city">Milano</span>
                                        </div>
                                        <div class="card-apartment-description">
                                            {{-- <span class="card-apartment-city">Milano</span> --}}
                                            <h2 class="card-apartment-header text-center">{{$apartment->title}}</h2>
                                            <p class="text-center">
                                                <i class="fas fa-euro-sign"></i>
                                                <span>Prezzo per notte: {{$apartment->price_per_night}}€</span>
                                            </p>

                                        </div>

                                    </div>
                                </a>
                            </div>




                            {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-5">
                                <a id="sponsored-apartment-card" href="{{ route('guest.apartments.show', ['slug' => $apartment->slug]) }}" class="card h-100 m-3">
                                    <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="mw-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Id: {{$apartment->id}}</h5>
                                        <p class="card-text">{{ $apartment->title }}</p>
                                        <p class="card-text">Città: {{ $apartment->street_name }} </p>
                                    </div>
                                </a>
                            </div> --}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
