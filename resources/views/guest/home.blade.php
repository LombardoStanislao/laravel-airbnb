@extends('layouts.app')

@section('header')
    <header>
        @include('guest.partials.navbar-top')
    </header>
@endsection

@section('content')
    <h1>Hello</h1>
    <i class="fas fa-search"> Search</i>
@endsection
