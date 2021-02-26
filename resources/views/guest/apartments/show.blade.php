@extends('layouts.app')

@section('scripts')
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.5.0/services/services-web.min.js"></script>
    <script type="text/javascript" defer>

        var nummberOfImages = "{{ $apartment->images->count()+1 }}";

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
    <header id="header-apartment-details">
        @include('guest.partials.navbar-top')
    </header>
@endsection

@section('content')
    <div id="apartment-page" v-cloak>
        <div class="slider d-lg-none">
            <img v-if="imgIndex == 0" src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="d-block w-100">
            @foreach ($apartment->images as $index => $image)
                <img v-if="imgIndex == {{ $index+1 }}" src="{{ asset("storage/" . $image->url) }}" class="w-100">
            @endforeach
            <div v-if="nummberOfImages>1" class="prev" @click="prev()">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div v-if="nummberOfImages>1" class="next" @click="next()">
                <i class="fas fa-arrow-right"></i>
            </div>
            <div v-if="nummberOfImages>1" class="counter">
                @{{ imgIndex+1 }}/@{{ nummberOfImages }}
            </div>
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
                <div class="col-6 mb-2 d-none d-lg-block">
                    <div class="overflow-hidden rounded">
                        <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="d-block main-image">
                    </div>
                </div>
                <div class="col-6 mb-2 d-none d-lg-block">
                    <div class="row">
                        @foreach ($apartment->images as $index => $image)
                            <div class="col-6">
                                <div class="overflow-hidden rounded">
                                    <img id="secondary-image-{{ $index+1 }}" src="{{ asset("storage/" . $image->url) }}" class="d-block secondary-image">
                                </div>
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
                                <strong>Numero bagni:</strong>
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
                    <p class="mb-0">
                        @if ($apartment->description)
                            <span>{{ $apartment->description }}</span>
                        @else
                            <span>Descrizione non disponibile</span>
                        @endif
                    </p>
                    @if (!Auth::user() || Auth::user()->id != $apartment->user_id)
                        <a class="btn btn-primary mt-4" href="{{ route('guest.apartments.message', [ 'slug' => $apartment->slug]) }}">
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
                        <div class="pb-4">Nessun comfort disponibile</div>
                    @endif
                </div>
                <div class="col-12">
                    <h3 class="border-top pt-4 pb-4 mb-0">Posizione:</h3>
                    <span>{{ $apartment->address }}</span>
                    <div id="map" class="mt-4 overflow-hidden rounded">

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
