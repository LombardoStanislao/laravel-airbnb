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

@section('content')
    <div id="apartment-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>{{ $apartment->title }}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul>
                        <li>
                            <strong>Numero di stanze:</strong>
                            <span>{{ $apartment->rooms_number }}</span>
                        </li>
                        <li>
                            <strong>Numero posti letto:</strong>
                            <span>{{ $apartment->sleeps_accomodations }}</span>
                        </li>
                        <li>
                            <strong>Numero di bagni:</strong>
                            <span>{{ $apartment->bathrooms_number }}</span>
                        </li>
                        <li>
                            <strong>Metri quadrati:</strong>
                            <span>{{ $apartment->mq }}</span>
                        </li>
                        <li>
                            <strong>Prezzo per notte:</strong>
                            <span>€ {{ $apartment->price_per_night }}</span>
                        </li>
                        <li>
                            <strong>Indirizzo:</strong>
                            <span id="adress_id"></span>
                        </li>
                        <li>
                            <strong>Lat:</strong>
                            <span>{{ $apartment->latitude }},</span>
                            <strong>Lon:</strong>
                            <span>{{ $apartment->longitude }}</span>
                        </li>
                        <li>
                            <strong>Disponibile:</strong>
                            <span>{{ $apartment->available ? 'Sì' : 'No' }}</span>
                        </li>
                        <li>
                            <strong>Comfort:</strong>
                            @if ($apartment->comforts->isNotEmpty())
                                @foreach ($apartment->comforts as $comfort)
                                    <span>
                                        {{ !$loop->last ? $comfort->name . ', ' : $comfort->name }}
                                    </span>
                                @endforeach
                            @else
                                <span>nessuno</span>
                            @endif
                        </li>
                        <li class="w-50">
                            <strong>Immagine di copertina:</strong>
                            <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="d-block mw-100">
                        </li>
                        <li>
                            <strong>Descrizione:</strong>
                            @if ($apartment->description)
                                <span>{{ $apartment->description }}</span>
                            @else
                                <span>Non disponibile</span>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="col-12">
                    <div id="map">

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
