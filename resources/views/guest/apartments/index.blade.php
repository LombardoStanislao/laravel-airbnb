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
                        <input type="range" id="radius" v-model="radius" min="500" max="50000" step="500">
                        <label for="radius">@{{ radius/1000 }} Km</label>
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
                        <li v-for="apartment in apartments">
                            {{-- <a href="#" @click="getApartmentsFiltered()"> --}}
                            <a :href="'/apartments/' + apartment.id">
                                @{{ apartment.title }}
                            </a>
                        </li>
                    </ul>
                    <ul v-else>
                        @foreach ($apartments as $apartment)

                            <a class="d-block" href="{{ route('guest.apartments.show', ['param' => $apartment->id]) }}" >
                                <div class="m-2 clearfix bg-secondary">
                                    <div class="float-left" style="width: 100px; height: 100px;">
                                        <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" alt="" class="w-100 h-100">
                                    </div>
                                    <div class="float-left ml-2 text-dark">
                                        <p>{{ $apartment->title }}</p>
                                        <p>{{ $apartment->price_per_night }}€</p>
                                        <p>Disponibile: {{ $apartment->available ? 'Sì' : 'No' }}</p>

                                    </div>
                                </div>

                            </a>

                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
