@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Appartamenti nel raggio di 20km da {{$location}}</h1>
            <ul>
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
@endsection
