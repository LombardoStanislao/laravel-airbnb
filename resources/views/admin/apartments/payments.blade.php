@extends('layouts.dashboard')

@section('page-title', 'Dettagli appartamento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (session('success_message'))
                    <div class="alert alert-success">
                        {{ session('success_message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
