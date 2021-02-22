@extends('layouts.dashboard')

@section('page-title', 'Sponsorizza appartamento')

@section('scripts')
    <script src="https://js.braintreegateway.com/web/dropin/1.26.0/js/dropin.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (session('error_message'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error_message') }}
                    </div>
                @endif
                @error ('sponsorship_type_id')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
                <form ref="paymentForm" id="payment-form" action="{{ route('admin.checkout', ['apartment_id' => $apartment_id]) }}" method="POST" @submit.prevent="submitForm()" v-cloak>
                    @csrf
                    <h1>Sponsorizza appartamento {{$apartment_id}}</h1>
                    <strong>Sponsorizzazioni disponibili: </strong>
                    <div class="d-flex flex-wrap">
                        @foreach ($sponsorship_types as $sponsorship_type)
                            <div class="card m-3" style="width: 18rem;">
                                <div class="card-body">
                                    <label>{{ $sponsorship_type->type_name }}</label>
                                    <input type="radio" name="sponsorship_type_id" value="{{$sponsorship_type->id}}">
                                    <ul>
                                        <li>
                                            <strong>Durata:</strong>
                                            {{ $sponsorship_type->duration }} ore
                                        </li>
                                        <li>
                                            <strong>Prezzo:</strong>
                                            € {{ $sponsorship_type->price }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="bt-drop-in-wrapper">
                        <div id="bt-dropin"></div>
                    </div>

                    <input id="nonce" v-model="nonce" type="hidden" name="payment_method_nonce">
                    <button id="submitButton" v-if="loaded" type="submit" class="btn btn-success">
                        <span>Conferma pagamento</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
