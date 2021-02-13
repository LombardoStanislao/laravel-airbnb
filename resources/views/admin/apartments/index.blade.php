@extends('layouts.dashboard')

@section('page-title', 'I tuoi appartamenti')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <h1>
                    {{ count($apartments) ? 'I tuoi appartamenti' : 'Nessun appartamento presente' }}
                </h1>
            </div>
            <div class="col-12 col-md-6 text-right">
                <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary">
                    Inserisci appartamento
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
                                    <td>{{ $apartment->title }}</td>
                                    <td>
                                        <a href="{{ route('admin.apartments.show', ['apartment' => $apartment->id]) }}" class="btn btn-info">
                                            Dettagli
                                        </a>
                                        <a href="{{ route('admin.apartments.edit', ['apartment' => $apartment->id]) }}" class="btn btn-warning">
                                            Modifica
                                        </a>
                                        <a href="{{ route('admin.apartments.destroy', ['apartment' => $apartment->id]) }}" class="btn btn-danger">
                                            Elimina
                                        </a>
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
