@extends('layouts.dashboard')

@section('page-title', 'Sponsorizza appartamento')

@section('scripts')
    <script src="https://js.braintreegateway.com/web/dropin/1.26.0/js/dropin.min.js"></script>
    <script type="text/javascript">
        function setAmount(price) {
            document.getElementById('amount').value = price;
        }

        var form = document.getElementById('payment-form');
        var client_token = '{{ $token }}';

        braintree.dropin.create({
            authorization: client_token,
            selector: '#bt-dropin'
        }, function(createErr, instance) {
            if (createErr) {
                console.log('Create Error', createErr);
                return;
            }
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                instance.requestPaymentMethod(function(err, payload) {
                    if (err) {
                        console.log(err);
                        return;
                    }

                    document.getElementById('nonce').value = payload.nonce;
                    form.submit();
                });
            });
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Sponsorizza appartamento {{$apartment_id}}</h1>
                <strong>Sponsorizzazioni disponibili: </strong>
                <div class="d-flex flex-wrap">
                    @foreach ($sponsorship_types as $sponsorship_type)
                        <div class="card m-3" style="width: 18rem;">
                            <div class="card-body">
                                <label>{{ $sponsorship_type->type_name }}</label>
                                <input onchange="setAmount({{ $sponsorship_type->price }})" type="radio" name="sponsorship" value="{{$sponsorship_type->id}}">
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
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form id="payment-form" action="{{ route('admin.checkout', ['apartment_id' => $apartment_id]) }}" method="POST">
                    @csrf
                    <section>
                        <label for="amount">
                            <span class="input-label">Amount</span>
                            <div class="input-wrapper amount-wrapper">
                                <input id="amount" type="tel" name="amount" placeholder="Amount">
                            </div>
                        </label>

                        <div class="bt-drop-in-wrapper">
                            <div id="bt-dropin"></div>
                        </div>
                    </section>

                    <input id="nonce" type="hidden" name="payment_method_nonce">
                    <button type="submit" class="button">
                        <span>Test Transaction</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
