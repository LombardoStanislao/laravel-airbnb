@extends('layouts.app')

@section('content')
    <h1>message</h1>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('guest.apartments.sendMessage', [ 'slug' => $apartment->slug ]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="d-block" for="mail_sender">Inserire la propria email:</label>
                        <input class="form-control" placeholder="inserire la propria email..." id="mail_sender" type="email" name="mail_sender" value="{{ Auth::user() ? Auth::user()->email : '' }}">
                    </div>

                    <div class="form-group">
                        <label class="d-block" for="body_message">Inserire la propria email:</label>
                        <textarea class="form-control" id="body_message" name="body_message" rows="10" placeholder="Inserire messaggio..."></textarea>
                    </div>

                    <input class="d-none" type="text" name="apartment_id" value="{{ $apartment->id }}">

                    <input class="btn btn-primary" type="submit" value="Premi per inviare">
                </form>

            </div>
        </div>
    </div>
@endsection
