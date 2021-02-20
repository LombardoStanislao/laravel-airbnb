@extends('layouts.dashboard')

@section('page-title', 'I tuoi messaggi')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <h1>
                    {{ $messages->count() ? 'I tuoi messaggi' : 'Nessun messaggio presente' }}
                </h1>
            </div>
        </div>
        @if ($messages->count())
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Mittente</th>
                                <th scope="col">Preview messaggio</th>
                                <th scope="col">Vedi messaggio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr>
                                    <td>
                                        @if ($message->is_new)
                                            <span class="badge badge-success">new</span>
                                        @endif
                                        {{ $message->mail_sender }}
                                    </td>
                                    <td class="overflow-hidden">
                                        {{ $message->body_message }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.messages.show', ['id' => $message->id]) }}" class="btn btn-info">
                                            Dettagli
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
