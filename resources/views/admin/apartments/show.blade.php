@extends('layouts.dashboard')

@section('page-title', 'Dettagli appartamento')

@section('content')
    <div id="show-apartment" class="row">
        <div class="col-12 col-lg-10">
            @if (session('apartment-created'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success" role="alert">
                            {{ session('apartment-created') }}
                        </div>
                    </div>
                </div>
            @endif
            @if (session('apartment-modified'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success" role="alert">
                            {{ session('apartment-modified') }}
                        </div>
                    </div>
                </div>
            @endif
            @if (session('success-transaction'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success" role="alert">
                            {{ session('success-transaction') }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row mt-4 mb-4">
                <div class="col-12 col-sm-6 mb-2">
                    <h1 class="d-flex align-items-center">
                        <span class="mr-2">{{ $apartment->title }}</span>
                        @if (isSponsored($apartment))
                            <small class="sponsored d-sm-none">sponsorizzato</small>
                        @endif
                    </h1>
                    @if (isSponsored($apartment))
                        <small class="sponsored d-none d-sm-inline-block">sponsorizzato</small>
                    @endif
                </div>
                <div class="col-12 col-sm-6 text-sm-right">
                    <a class="btn btn-primary" href="{{ route('admin.statistics', ['apartment_id' => $apartment->id]) }}">
                        Statistiche
                    </a>
                    <a class="btn btn-warning" href="{{ route('admin.messages.index', ['apartment_id' => $apartment->id]) }}">
                        Messaggi
                    </a>
                </div>
            </div>
            <div class="row mt-2 mb-2">
                <div class="col-12 col-xl-6">
                    <div class="primary-image">
                        <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="w-100 h-100">
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="row mt-2 mt-xl-0">
                        @foreach ($images as $index => $image)
                            <div class="col-6">
                                <div class="secondary-image-{{ $index }}">
                                    <img src="{{ asset("storage/" . $image->url) }}" class="w-100 h-100">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="list-unstyled">
                        <li class="pt-3 pb-3 border-bottom">
                            <strong>Numero di stanze:</strong>
                            <span>{{ $apartment->rooms_number }}</span>
                        </li>
                        <li class="pt-3 pb-3 border-bottom">
                            <strong>Numero posti letto:</strong>
                            <span>{{ $apartment->sleeps_accomodations }}</span>
                        </li>
                        <li class="pt-3 pb-3 border-bottom">
                            <strong>Numero di bagni:</strong>
                            <span>{{ $apartment->bathrooms_number }}</span>
                        </li>
                        <li class="pt-3 pb-3 border-bottom">
                            <strong>Metri quadrati:</strong>
                            <span>{{ $apartment->mq }}</span>
                        </li>
                        <li class="pt-3 pb-3 border-bottom">
                            <strong>Prezzo per notte:</strong>
                            <span>€ {{ $apartment->price_per_night }}</span>
                        </li>
                        <li class="pt-3 pb-3 border-bottom">
                            <strong>Indirizzo:</strong>
                            <span>{{ $apartment->address }}</span>
                        </li>
                        <li class="pt-3 pb-3 border-bottom">
                            <strong>Disponibile:</strong>
                            <span>{{ $apartment->available ? 'Sì' : 'No' }}</span>
                        </li>
                        <li class="pt-3 pb-3 border-bottom">
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
                        <li class="pt-3 pb-3 border-bottom">
                            <strong>Descrizione:</strong>
                            @if ($apartment->description)
                                <span>{{ $apartment->description }}</span>
                            @else
                                <span>Non disponibile</span>
                            @endif
                        </li>
                        <li class="pt-3 pb-3">
                            @if ($active_sponsorship)
                                <strong>Scadenza sponsorizzazione:</strong>
                                <span>{{ $active_sponsorship->created_at->addHours($active_sponsorship->sponsorshipType->duration) }}</span>
                            @else
                                <strong>Sponsorizzazione:</strong>
                                <span>Nessuna</span>
                            @endif
                        </li>
                        @if (!$active_sponsorship)
                            <li class="pt-3 pb-3">
                                <a href="{{ route('admin.apartments.sponsorship', ['id' => $apartment->id]) }}" class="btn btn-success">
                                    Sponsorizza il tuo appartamento
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
