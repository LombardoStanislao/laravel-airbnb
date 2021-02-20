@extends('layouts.dashboard')

@section('page-title', 'Messagio')

@section('content')
    <div id="message-page" data-message-id="{{ $message->id }}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Appartamento: {{ $apartment->title }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Inviato da: {{ $message->mail_sender }}</h5>
                            <p class="card-text">{{ $message->body_message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
