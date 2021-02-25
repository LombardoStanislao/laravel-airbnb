@extends('layouts.dashboard')

@section('page-title', 'Home dashboard')

@section('content')
<div class="row mt-4 mb-4">
    <div class="col-12 col-lg-10">
        <h1>Benvenuto {{ Auth::user()->name }}</h1>
    </div>
</div>
@endsection
