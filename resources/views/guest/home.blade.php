@extends('layouts.app')

@section('header')
    <header>
        @include('guest.partials.navbar-top')

    </header>
@endsection

@section('content')
    <form action="{{ route('search') }}" method="get">
        <button type="submit">
            <i class="fas fa-search"> Search</i>
        </button>
        <input type="text" name="location" value="" placeholder="Inserisci dove vuoi andare">
    </form>

@endsection
