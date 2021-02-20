@extends('layouts.app')

@section('scripts')
    <script type="text/javascript" defer>
        var noSponsoredApartments = "{{ $sponsored_apartments->isEmpty() }}";
    </script>
@endsection

@section('header')
    <header>
        @include('guest.partials.navbar-top')
    </header>
@endsection

@section('content')
    <div id="home" class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('search') }}" method="get">
                    <button type="submit">
                        <i class="fas fa-search"> Search</i>
                    </button>
                    <input type="text" name="location" value="" placeholder="Inserisci dove vuoi andare">
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if (!$sponsored_apartments->isEmpty())
                    <h1>Appartamenti in evidenza</h1>
                @endif
            </div>
            @foreach ($sponsored_apartments as $apartment)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-5">
                    <a href="{{ route('guest.apartments.show', ['slug' => $apartment->slug]) }}" class="card h-100 m-3">
                        <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="mw-100">
                        <div class="card-body">
                            <h5 class="card-title">Id: {{$apartment->id}}</h5>
                            <p class="card-text">{{ $apartment->title }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                @if (!$sponsored_apartments->isEmpty() && !$non_sponsored_apartments->isEmpty())
                    <button @click="showMore ? showMore = false : showMore = true" class="btn btn-success">Mostra altri appartamenti</button>
                @endif
            </div>

            <div class="col-12" v-if="showMore || noSponsoredApartments">
                <div class="row">
                    @foreach ($non_sponsored_apartments as $apartment)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-5">
                            <a href="{{ route('guest.apartments.show', ['slug' => $apartment->slug]) }}" class="card h-100 m-3">
                                <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="mw-100">
                                <div class="card-body">
                                    <h5 class="card-title">Id: {{$apartment->id}}</h5>
                                    <p class="card-text">{{ $apartment->title }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
