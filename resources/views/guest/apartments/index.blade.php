@extends('layouts.app')

@section('content')
    <div id="root">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <section class="filters">
                        <label for="locationName">Posto ricercato: </label>
                        <input type="text" v-model.trim="locationName">

                        <label for="minimumRooms">Stanze minime: </label>
                        <input type="number" v-model.trim="minimumRooms" placeholder="es. 1">


                        <label for="minimumSleepsAccomodations">posti letto: </label>
                        <input type="number" v-model.trim="minimumSleepsAccomodations" placeholder="es. 1">

                        <label for="radius">raggio di ricerca in metri: </label>
                        <input type="number" v-model.trim="radius" placeholder="es. 1">

                        <div class="checkbox-container">
                            @foreach ($comforts as $comfort)
                                <input id="checkbox{{ $comfort->id }}" type="checkbox" v-model="checkedComfortsId" value="{{ $comfort->id }}">
                                <label for="checkbox{{ $comfort->id }}">{{ $comfort->name }}</label>
                            @endforeach
                        </div>

                        <button type="button" @click='getApartmentsFiltered'>Filtra ricerca</button>
                    </section>
                    <h1 id="advanced-research-page">
                        Appartamenti nel raggio di <span v-cloak>@{{ radius/1000 }}</span> Km da
                        <span id="location-data" data-location-coordinates={{ $locationCoordinates }} data-location-name={{ str_replace(' ', '__', $locationName) }} >{{$locationName}}<span>
                    </h1>

                    <ul v-if="apartments">
                        <li v-for="apartment in apartments">@{{ apartment.title }}</li>
                    </ul>
                    <ul v-else>
                        @foreach ($apartments as $apartment)
                            <li>
                                <a href="{{ route('guest.apartments.show', ['param' => $apartment->id]) }}" >
                                    {{ $apartment->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
