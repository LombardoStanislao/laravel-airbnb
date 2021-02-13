@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Benvenuto {{ Auth::user()->name }}</h1>
            {{-- <a href="{{route('admin.apartments.index')}}" class="btn btn-info">
                Pagina Index ApartmentController
            </a>
            <a href="{{route('admin.apartments.create')}}" class="btn btn-info">
                Pagina Create ApartmentController
            </a> --}}

        </div>
    </div>
</div>
@endsection
