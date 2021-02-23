@extends('layouts.app')

@section('scripts')
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.5.0/services/services-web.min.js"></script>
    <script type="text/javascript" defer>

        var longitude_js = "{{$apartment->longitude}}";
        // console.log(longitude_js);
        var latitude_js = "{{$apartment->latitude}}";
        // console.log(latitude_js);

        function callbackFn() {
            tt.services.reverseGeocode({
                key: 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC',
                position: {longitude: longitude_js, latitude: latitude_js}
            }).then(response => {
                // console.log(response.addresses[0].address);
                address = response.addresses[0].address.freeformAddress;
                document.getElementById("adress_id").innerHTML = address;
            })
        }

        callbackFn();
    </script>
@endsection

@section('header')
    @include('guest.partials.navbar-top')
@endsection

@section('content')
    <div id="apartment-page">
        <div class="d-md-none">
            <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="d-block w-100">
        </div>
        <div class="container">
            <div class="row mt-4 mb-4">
                <div class="col-12 mb-2">
                    <h1>{{ $apartment->title }}</h1>
                </div>
                <div class="col-12 mb-2">
                    <div class="address">{{ $apartment->address }}</div>
                    <div class="availability {{ $apartment->available ? 'green' : 'red' }}">
                        @if ($apartment->available)
                            <span class="green">
                                <i class="fas fa-check-circle"></i>
                                Disponibile
                            </span>
                        @else
                            <span class="red">
                                <i class="fas fa-times-circle"></i>
                                Non disponibile
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-6 mb-2 d-none d-md-block">
                    <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="d-block w-100">
                </div>
                <div class="col-6 mb-2 d-none d-md-block">
                    <div class="row">
                        @foreach ($apartment->images as $index => $image)
                            <div class="col-6 {{ $index > 4 ? 'd-none' : '' }}">
                                <img src="{{ asset("storage/" . $image->url) }}" class="d-block w-100">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="list-unstyled border-top border-bottom mb-0">
                        <li class="pt-4 pb-4">
                            <h3 class="mb-0">Caratteristiche:</h3>
                        </li>
                        <li class="pt-4 pb-4 d-flex align-items-center">
                            <div class="icon mr-3">
                                <i class="fas fa-home fa-2x"></i>
                            </div>
                            <div class="info">
                                <strong>Numero stanze:</strong>
                                <span>{{ $apartment->rooms_number }}</span>
                            </div>
                        </li>
                        <li class="pt-4 pb-4 d-flex align-items-center">
                            <div class="icon mr-3">
                                <i class="fas fa-bed fa-2x"></i>
                            </div>
                            <div class="info">
                                <strong>Numero posti letto:</strong>
                                <span>{{ $apartment->sleeps_accomodations }}</span>
                            </div>
                        </li>
                        <li class="pt-4 pb-4 d-flex align-items-center">
                            <div class="icon mr-3">
                                <i class="fas fa-toilet fa-2x"></i>
                            </div>
                            <div class="info">
                                <strong>Numero di bagni:</strong>
                                <span>{{ $apartment->bathrooms_number }}</span>
                            </div>
                        </li>
                        <li class="pt-4 pb-4 d-flex align-items-center">
                            <div class="icon mr-3">
                                <i class="fas fa-ruler-combined fa-2x"></i>
                            </div>
                            <div class="info">
                                <strong>Metratura:</strong>
                                <span>{{ $apartment->mq }} mq</span>
                            </div>
                        </li>
                        <li class="pt-4 pb-4 d-flex align-items-center">
                            <div class="icon mr-3">
                                <i class="fas fa-coins fa-2x"></i>
                            </div>
                            <div class="info">
                                <strong>Prezzo per notte:</strong>
                                <span>€ {{ $apartment->price_per_night }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-12 pt-4 pb-4">
                    <h3 class="mb-4">Descrizione:</h3>
                    <p class="mb-4">
                        @if ($apartment->description)
                            <span>{{ $apartment->description }}</span>
                        @else
                            <span>Descrizione non disponibile</span>
                        @endif
                    </p>
                    @if (!Auth::user() || Auth::user()->id != $apartment->user_id)
                        <a class="btn btn-primary" href="{{ route('guest.apartments.message', [ 'slug' => $apartment->slug]) }}">
                            Contatta l'host
                        </a>
                    @endif
                </div>
                <div class="col-12">
                    <h3 class="border-top pt-4 pb-4 mb-0">Comfort:</h3>
                    @if ($apartment->comforts->isNotEmpty())
                        <ul class="list-unstyled m-0">
                            @foreach ($apartment->comforts as $comfort)
                                <li class="pb-4 d-flex">
                                    <div class="mr-3 icon icon-comfort-{{ $comfort->id }}">

                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span>{{ $comfort->name }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span>Nessun comfort disponibile</span>
                    @endif
                </div>
                <div class="col-12">
                    <h3 class="border-top pt-4 pb-4 mb-0">Posizione:</h3>
                    <span>{{ $apartment->address }}</span>
                    <div id="map" class="mt-4 mb-4 mb-0">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <form class="d-none" action="index.html" method="post">
        <input type="text" name="user" value="{{ Auth::user() ? Auth::user()->id : '' }}">
        <input type="text" name="apartment" value="{{ $apartment->id }}">
    </form>
@endsection
