@extends('layouts.app')

@section('content')
    <div id="root" v-cloak>
        <div id="advanced-research-page">
            <header id="header-apartment-details">
                <div class="desktop-header d-none d-md-block">
                    @include('guest.partials.navbar-top')
                </div>
                <div class="mobile-header d-md-none">
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
                        </div>
                    </div>
                </div>
            </header>


            <div id="dropdown-filters-menu" class="d-none">
                <div id="dropdown-filters-menu-container">
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

            <div id="main-content">
                <div class="container-lg">
                    <div class="content-header" id="location-data" data-location-coordinates={{ $locationCoordinates }} data-location-name={{ str_replace(' ', '__', $locationName) }}>
                        <div v-if="apartments">
                            <p v-if="apartments.length">
                                @{{ apartments.length }} appartamenti
                            </p>
                            <p v-else>
                                Non ci sono appartamenti disponibili
                            </p>
                            <h2>@{{ locationName }}</h2>
                        </div>
                        <div v-else>
                            @if ($apartments->count())
                                <p>
                                    {{ $apartments->count() }} appartamenti
                                </p>
                            @else
                                <p>
                                    Non ci sono appartamenti disponibili
                                </p>
                            @endif
                            <h2>{{ $locationName }}</h2>
                        </div>
                        <button @click="toggleFilterDropdown" class="btn sp-transparent-btn">
                            Filtri
                        </button>
                    </div>
                </div>

                <ul v-if="apartments" class="apartment-list vue" :data-apartment-number="apartments.length">
                    <li v-for="apartment in apartments">
                        <a id="apartment-card" :href="'/apartments/' + apartment.slug" class="apartment-card">
                            <div class="container-lg">
                                <div class="row">
                                    <div class="col-12 col-md-5">
                                        <div class="img-container clearfix">
                                            <img :src="'storage/' + apartment['main-image']" :alt="apartment.title + 'foto'">
                                            <small v-if="sponsoredApartments.includes(apartment.id)" class="sponsored d-md-none">sponsorizzato</small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <div class="apartment-info-container">
                                            <small v-if="sponsoredApartments.includes(apartment.id)" class="sponsored d-none d-md-block">sponsorizzato</small>
                                            <h3>@{{ apartment.title }}</h3>
                                            <p>
                                                <span>
                                                    @{{ apartment.sleeps_accomodations }} ospiti &middot;
                                                </span>
                                                <span>
                                                    @{{ apartment.rooms_number }} camere &middot;
                                                </span>
                                                <span>
                                                    @{{ apartment.bathrooms_number }} bagni &middot;
                                                </span>

                                                <span v-if="apartment.comforts.length > 3">
                                                    <span v-for="i in 3">
                                                        @{{ apartment.comforts[i - 1].name }}
                                                        @{{ i == 3 ? '...' : '·'}}
                                                    </span>
                                                </span>
                                                <span v-else-if="apartment.comforts.length">
                                                    <span v-for="(comfort, index) in apartment.comforts">
                                                        @{{ comfort.name }}
                                                        @{{ index == apartment.comforts.length - 1 ? '' : '·' }}
                                                    </span>
                                                </span>
                                            </p>
                                            <p class="price">
                                                <strong>
                                                    @{{ apartment.price_per_night }}&euro;
                                                </strong>
                                                / notte
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
                <ul v-else class="apartment-list" data-apartment-number="{{ $apartments->count() }}">
                    @foreach($apartments as $apartment)
                            <li v-if="isRightPage({{ $loop->index }})">
                                <a id="apartment-card" href="{{ route('guest.apartments.show', ['slug' => $apartment->slug]) }}" class="apartment-card">
                                    <div class="container-lg">
                                        <div class="row">
                                            <div class="col-12 col-md-5">
                                                <div class="img-container clearfix">
                                                    <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" alt="{{ $apartment->title }} foto">
                                                    @if (isSponsored($apartment))
                                                        <small class="sponsored d-md-none">sponsorizzato</small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="apartment-info-container">
                                                    @if (isSponsored($apartment))
                                                        <small class="sponsored d-none d-md-block">sponsorizzato</small>
                                                    @endif

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
                    <li class="page-input">
                        <i v-if="page" class="btn sp-transparent-btn fas fa-arrow-left" @click="page--"></i>
                        <i v-else class="btn sp-transparent-btn fas fa-arrow-left unavailable"></i>

                        @for ($i = 0; $i < $apartments->count() / 10; $i++)
                            <span :class="page == {{ $i }} ? 'current-page' : ''">
                                {{ $i + 1 }}
                            </span>
                        @endfor

                        <i v-if="page != {{ floor(($apartments->count() - 1) / 10) }}" class="btn sp-transparent-btn fas fa-arrow-right" @click="page++"></i>
                        <i v-else class="btn sp-transparent-btn fas fa-arrow-right unavailable"></i>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
