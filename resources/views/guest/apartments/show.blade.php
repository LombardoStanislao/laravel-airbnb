@extends('layouts.app')

@section('scripts')
    <script type="text/javascript" defer>
        var apartmentId = "{{ $apartment->id }}";
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
            <transition-group :name="slidingDirection">
                @foreach ($images as $index => $image_url)
                        <img v-show="imgIndex == {{ $index }}" src="{{ asset("storage/" . $image_url) }}" class="w-100" :key="{{ $index }}">
                @endforeach
            </transition-group>
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
        <div v-show="!sliderVisible" class="container">
            <div class="row mt-4 mb-4">
                @if (session('message-sent'))
                    <div class="col-12">
                        <div class="alert alert-success" role="alert">
                            {{ session('message-sent') }}
                        </div>
                    </div>
                @endif
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
                        <img @click="showSlider(0)" src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="d-block main-image">
                    </div>
                </div>
                <div class="col-6 mb-2 d-none d-lg-block">
                    <div class="row">
                        @foreach ($apartment->images as $index => $image)
                            <div class="col-6">
                                <div class="overflow-hidden rounded">
                                    <img @click="showSlider({{ $index+1 }})" id="secondary-image-{{ $index+1 }}" src="{{ asset("storage/" . $image->url) }}" class="d-block secondary-image">
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
                        <a @click.prevent="showMessageForm = true" class="btn btn-primary mt-4" href="#">
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
        <transition name="fade-slider-container">
            <div v-if="sliderVisible" class="slider-container d-none d-lg-block">
                <div @click="sliderVisible = false" class="close">
                    <i class="fas fa-times fa-2x"></i>
                </div>
                <div class="slider h-100 overflow-hidden rounded">
                    <transition-group :name="slidingDirection">
                        @foreach ($images as $index => $image_url)
                                <img v-show="imgIndex == {{ $index }}" src="{{ asset("storage/" . $image_url) }}" class="w-100" :key="{{ $index }}">
                        @endforeach
                    </transition-group>
                </div>
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
        </transition>
        <transition name="alert">
            <div @click="showMessageForm = false" v-show="showMessageForm" id="message-form">
                <div @click="preventClosure()" class="form-container">
                    <div @click="showMessageForm = false" class="close">
                        <i class="fas fa-times fa-2x"></i>
                    </div>
                    <form action="{{ route('guest.apartments.sendMessage', [ 'slug' => $apartment->slug ]) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="d-block" for="mail_sender">Indirizzo email:</label>
                            <input class="form-control" placeholder="Inserire indirizzo email..." id="mail_sender" type="email" name="mail_sender" value="{{ Auth::user() ? Auth::user()->email : '' }}">
                        </div>

                        <div class="form-group">
                            <label class="d-block" for="body_message">Messaggio:</label>
                            <textarea class="form-control" id="body_message" name="body_message" rows="10" placeholder="Inserire messaggio..."></textarea>
                        </div>

                        <input class="d-none" type="text" name="apartment_id" value="{{ $apartment->id }}">

                        <input class="btn btn-success" type="submit" value="Invia">
                    </form>
                </div>
            </div>
        </transition>
    </div>
@endsection
