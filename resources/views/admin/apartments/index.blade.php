@extends('layouts.dashboard')

@section('page-title', 'I tuoi appartamenti')

@section('content')
    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-12 col-sm-6 mb-2">
                <h1>
                    {{ count($apartments) ? 'I tuoi appartamenti' : 'Nessun appartamento presente' }}
                </h1>
            </div>
            <div class="col-12 col-sm-6 text-sm-right">
                <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary">
                    Aggiungi appartamento
                </a>
            </div>
        </div>
        @if (count($apartments))
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Titolo riepilogativo</th>
                                <th scope="col">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apartments as $apartment)
                                <tr>
                                    <td>{{ $apartment->id }}</td>
                                    <td>
                                        {{ $apartment->title }}
                                    </td>
                                    <td>
                                        <div class="dropdown d-lg-none mw-0">
                                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Azioni
                                            </button>
                                            <div class="dropdown-menu text-center" aria-labelledby="dropdownMenu2">
                                                <a href="{{ route('admin.apartments.show', ['apartment' => $apartment->id]) }}" class="btn btn-info mb-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.apartments.edit', ['apartment' => $apartment->id]) }}" class="btn btn-warning mb-1">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form class="d-inline-block mb-1" method="post" action="{{ route('admin.apartments.destroy', ['apartment'=> $apartment->id])}}" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit" name="button">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="d-none d-lg-block">
                                            <a href="{{ route('admin.apartments.show', ['apartment' => $apartment->id]) }}" class="btn btn-info">
                                                Dettagli
                                            </a>
                                            <a href="{{ route('admin.apartments.edit', ['apartment' => $apartment->id]) }}" class="btn btn-warning">
                                                Modifica
                                            </a>
                                            <form class="d-inline-block" method="post" action="{{ route('admin.apartments.destroy', ['apartment'=> $apartment->id])}}" >
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit" name="button">
                                                    Elimina
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
