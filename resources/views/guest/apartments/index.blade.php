@extends('layouts.app')

@section('content')
    <div id="root">
        <div id="advanced-research-page">
            <div class="mobile-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-9">
                            <div class="location-container">
                                <h3 class="location-name">{{ $locationName }}</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="filters-dropdown text-right">
                                <i @click="toggleFilterDropdown"  class="fas fa-sliders-h btn sp-secondary-btn"></i>
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="dropdown-filters-menu" class="d-none d-md-none">
                                <div class="header-dropdown">

                                    <div class="times-container">
                                        <i @click="toggleFilterDropdown" class="btn sp-secondary-btn fas fa-times"></i>
                                    </div>

                                    <h4>Filtri</h4>

                                    <button @click="clearFilters" class="btn sp-secondary-btn">
                                        <u>Annulla</u>
                                    </button>
                                </div>
                                <ul class="filter-section-list">
                                    <li>
                                        <h2>
                                            Raggio di ricerca
                                        </h2>
                                        <input type="range" id="radius" v-model="radius" min="500" max="100000" step="500">
                                        <label for="radius">@{{ radius/1000 }} Km</label>
                                    </li>

                                    <li>
                                        <h2>
                                            Camere e posti letto
                                        </h2>

                                        <ul>
                                            <li class="clearfix">
                                                <div class="left">
                                                    <label for="minimumRooms">Camere</label>
                                                    <input class="d-none" type="number" v-model.trim="minimumRooms">
                                                </div>

                                                <div class="right">
                                                    <button v-if="minimumRooms" @click="minimumRooms--" class="value-modifier ">-</button>
                                                    <button v-else class="value-modifier  unavailable">-</button>
                                                    <span class="input-value">@{{ minimumRooms }}</span>
                                                    <button @click="minimumRooms++" class=" value-modifier">+</button>
                                                </div>
                                            </li>

                                            <li class="clearfix">
                                                <div class="left">
                                                    <label for="minimumSleepsAccomodations">Posti letto</label>
                                                    <input class="d-none" type="number" v-model.trim="minimumSleepsAccomodations">
                                                </div>

                                                <div class="right">
                                                    <button v-if="minimumSleepsAccomodations" @click="minimumSleepsAccomodations--" class="value-modifier ">-</button>
                                                    <button v-else class="value-modifier unavailable">-</button>
                                                    <span class="input-value">@{{ minimumSleepsAccomodations }}</span>
                                                    <button @click="minimumSleepsAccomodations++" class=" value-modifier">+</button>
                                                </div>
                                            </li>

                                            <li class="clearfix">
                                                <div class="left">
                                                    <label for="minimumBathrooms">Bagni</label>
                                                    <input class="d-none" type="number" v-model.trim="minimumBathrooms">
                                                </div>

                                                <div class="right">
                                                    <button v-if="minimumBathrooms" @click="minimumBathrooms--" class="value-modifier">-</button>
                                                    <button v-else class="value-modifier unavailable">-</button>
                                                    <span class="input-value">@{{ minimumBathrooms }}</span>
                                                    <button @click="minimumBathrooms++" class="value-modifier">+</button>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>

                                    <li>
                                        <h2>
                                            Comforts
                                        </h2>

                                        <ul class="comfort-list">
                                            @foreach ($comforts as $comfort)
                                                <li class="clearfix">
                                                    <label for="checkbox{{ $comfort->id }}">{{ $comfort->name }}</label>
                                                    <input class="checkbox" id="checkbox{{ $comfort->id }}" type="checkbox" v-model="checkedComfortsId" value="{{ $comfort->id }}">
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                                <div class="footer-dropdown">
                                    <button class="btn sp-primary-btn" type="button" @click='getApartmentsFiltered'>
                                        Applica filtri
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="main-content">
                <div class="container-fluid">
                    <div class="content-header" id="location-data" data-location-coordinates={{ $locationCoordinates }} data-location-name={{ str_replace(' ', '__', $locationName) }}>
                        <div v-if="apartments">
                            <p>
                                @{{ apartments.length }} appartamenti
                            </p>
                            <h2>@{{ locationName }}</h2>
                        </div>
                        <div v-else>
                            <p>
                                {{ $apartments->count() }} appartamenti
                            </p>
                            <h2>{{ $locationName }}</h2>
                        </div>
                        <button @click="toggleFilterDropdown" class="btn sp-transparent-btn">
                            Filtri
                        </button>
                    </div>
                </div>

                <ul v-if="apartments" class="apartment-list">
                    <li v-for="apartment in apartments">
                        @{{apartment.title}}
                    </li>
                </ul>

                <ul v-else class="apartment-list">
                    @foreach ($apartments as $apartment)
                        <li>
                            <a href="{{ route('guest.apartments.show', ['slug' => $apartment->slug]) }}" class="apartment-card">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 col-md-5">
                                            <div class="img-container clearfix">
                                                <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" alt="{{ $apartment->title }} foto">

                                                @if (isSponsored($apartment))
                                                    <small class="sponsored">sponsorizzato</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <div class="apartment-info-container">
                                                <h3>{{ $apartment->title }}</h3>
                                                <p>
                                                    <span>
                                                        {{ $apartment->sleeps_accomodations }} ospiti &middot;
                                                    </span>
                                                    <span>
                                                        {{ $apartment->rooms_number }} camere &middot;
                                                    </span>
                                                    <span>
                                                        {{ $apartment->bathrooms_number }} bagni &middot;
                                                    </span>

                                                    @if (count($apartment->comforts) > 3)
                                                        @for ($i = 0; $i < 3; $i++)
                                                            <span>
                                                                {{ $apartment->comforts[$i]->name }}
                                                                {{$loop->last ? '...' : '·'}}
                                                            </span>
                                                        @endfor
                                                    @elseif ($apartment->comforts)
                                                        @foreach ($apartment->comforts as $comfort)
                                                            <span>
                                                                {{ $comfort->name }}
                                                                {{$loop->last ? '' : '·'}}
                                                            </span>
                                                        @endforeach
                                                    @endif
                                                </p>
                                                <p class="price">
                                                    <strong>
                                                        {{ $apartment->price_per_night }}&euro;
                                                    </strong>
                                                    / notte
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>


















        {{-- <div class="container">
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

                            <a class="card mb-2" :href="'/apartments/' + apartment.slug">

                                <div class="m-2 clearfix">
                                    <div class="float-left" style="width: 100px; height: 100px;">
                                        <img :src="'storage/' + apartment['main-image'] " alt="" class="w-100 h-100">
                                    </div>
                                    <div class="float-left ml-2 text-dark">
                                        <p class="mt-0 mb-0">@{{ apartment.id }}</p>
                                        <p class="mt-0 mb-0">@{{ apartment.title }}</p>
                                        <p class="mt-0 mb-0">@{{ apartment.price_per_night }}€</p>
                                        <p class="mt-0 mb-0">Indirizzo: @{{ apartment.address}}</p>
                                        <p class="mt-0 mb-0">Disponibile: @{{apartment.available? 'Sì' : 'No' }}</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <ul v-else>
                        @foreach ($apartments as $key => $apartment)

                            <a class="card mb-2" href="{{ route('guest.apartments.show', ['slug' => $apartment->slug]) }}" >
                                <div class="m-2 clearfix">
                                    <div class="float-left" style="width: 100px; height: 100px;">
                                        <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" alt="" class="w-100 h-100">
                                    </div>
                                    <div class="float-left ml-2 text-dark">
                                        <p class="mt-0 mb-0">Id: {{ $apartment->id }}</p>
                                        <p class="mt-0 mb-0">Sponsorizzazione attiva: {{ isSponsored($apartment) ? 'Sì' : 'No' }}</p>
                                        <p class="mt-0 mb-0">{{ $apartment->title }}</p>
                                        <p class="mt-0 mb-0">{{ $apartment->price_per_night }}€</p>
                                        <p class="mt-0 mb-0">Indirizzo: {{ $apartment->address }}</p>
                                        <p class="mt-0 mb-0">Disponibile: {{ $apartment->available ? 'Sì' : 'No' }}</p>

                                    </div>
                                </div>

                            </a>

                        @endforeach
                    </ul>
                </div>
            </div>
        </div> --}}
    </div>

@endsection
