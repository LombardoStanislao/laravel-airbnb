@extends('layouts.dashboard')

@section('page-title', 'Sponsorizza appartamento')

@section('scripts')
    <script src="https://js.braintreegateway.com/web/dropin/1.26.0/js/dropin.min.js"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-10">
            <div class="row mt-4 mb-4">
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
                    <h1>Sponsorizza l'appartamento {{$apartment_id}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-10">
                    <form ref="paymentForm" id="payment-form" action="{{ route('admin.checkout', ['apartment_id' => $apartment_id]) }}" method="POST" @submit.prevent="submitForm()" v-cloak>
                        @csrf
                        <h3>Sponsorizzazioni disponibili: </h3>
                        <div class="d-flex flex-wrap">
                            @foreach ($sponsorship_types as $sponsorship_type)
                                <div id="sponsorship-{{ $sponsorship_type->id }}-card" @click="selectSponsorship({{ $sponsorship_type->id }})" class="card m-3" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="text-uppercase">{{ $sponsorship_type->type_name }}</h5>
                                        <input id="sponsorship-{{ $sponsorship_type->id }}-input" class="d-none" type="radio" name="sponsorship_type_id" value="{{$sponsorship_type->id}}">
                                        <ul class="list-unstyled">
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
    </div>
@endsection
