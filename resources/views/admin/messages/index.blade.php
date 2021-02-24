@extends('layouts.dashboard')

@section('page-title', 'I tuoi messaggi')

@section('content')
    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-12 mb-2">
                <h1>
                    {{ $messages->count() ? 'Messaggi appartamento ' . $apartment_id : 'Nessun messaggio relativo all\'appartamento ' . $apartment_id }}
                </h1>
            </div>
        </div>
        @if ($messages->count())
            <div class="row">
                <div class="col-12" style="overflow-x:auto;">
                    <table id="messages-table" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Mittente</th>
                                <th scope="col">Messaggio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr >
                                    <td>
                                        {{-- @if ($message->is_new)
                                            <span class="badge badge-success">new</span>
                                        @endif --}}
                                        {{ $message->mail_sender }}
                                    </td>
                                    <td>
                                        {{ $message->body_message }}
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
