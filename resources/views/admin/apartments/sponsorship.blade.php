@extends('layouts.dashboard')

@section('page-title', 'Sponsorizza appartamento')

@section('scripts')
    <script src="https://js.braintreegateway.com/web/dropin/1.26.0/js/dropin.min.js"></script>
    <script type="text/javascript">
        function setSponsorshipType(type) {
            document.getElementById('sponsorship_type_id').value = type;
        }

        var form = document.getElementById('payment-form');
        var client_token = '{{ $token }}';

        braintree.dropin.create({
            authorization: client_token,
            selector: '#bt-dropin'
        }, function(createErr, instance) {
            if (createErr) {
                console.log('Create Error', createErr);
            } else {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    instance.requestPaymentMethod(function(err, payload) {
                        if (err) {
                            console.log(err);
                        } else {
                            document.getElementById('nonce').value = payload.nonce;
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form id="payment-form" action="{{ route('admin.checkout', ['apartment_id' => $apartment_id]) }}" method="POST">
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

                    <input id="nonce" type="hidden" name="payment_method_nonce">
                    <button type="submit" class="button">
                        <span>Test Transaction</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
