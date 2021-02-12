@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Dashbord Admin</h1>
            <a href="{{route('admin.apartments.index')}}" class="btn btn-info">
                Pagina Index ApartmentController
            </a>
            <a href="{{route('admin.apartments.create')}}" class="btn btn-info">
                Pagina Create ApartmentController
            </a>
            
        </div>
    </div>
</div>
@endsection
