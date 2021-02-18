@extends('layouts.dashboard')

@section('page-title', 'Dettagli appartamento')

@section('scripts')
    <script type="text/javascript" defer>
        var latitude = "{{ $apartment->latitude }}";
        var longitude = "{{ $apartment->longitude }}";
    </script>
@endsection

@section('content')
    <div id="show-apartment" class="container" v-cloak>
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
                        <span>@{{ adress }}</span>
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
                    <li>
                        <strong>Immagine di copertina:</strong>
                        <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="mw-100">
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
                @if ($active_sponsorship)
                    <h5>Sponsorizzazione attiva:</h5>
                    <ul>
                        <li>
                            <strong>Tipologia:</strong>
                            {{ $active_sponsorship->sponsorshipType->type_name }}
                        </li>
                        <li>
                            <strong>Scadenza:</strong>
                            {{$active_sponsorship->created_at->addHours($active_sponsorship->sponsorshipType->duration)}}
                        </li>
                    </ul>
                @else
                    <a href="{{ route('admin.apartments.sponsorship', ['id' => $apartment->id]) }}" class="btn btn-success">Sponsorizza il tuo appartamento</a>
                @endif
            </div>
            <canvas id="chart" width="400" height="200"></canvas>
        </div>
    </div>
@endsection
