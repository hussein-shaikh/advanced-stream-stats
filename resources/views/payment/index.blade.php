@extends('layouts.internal')




@section('content')
    @if (Auth::check())
        <form method="post" id="payment-form" action="{{ route('payment-checkout') }}">
            <input id="amount" name="amount" readonly min="1" placeholder="Amount" value="{{ $amount }}">

            <input name="payment_id" type="hidden" value="{{ $payment_id }}">
            @csrf
            <input value="{{ config('app.PAYMENT_VIA') }}" name="gateway" type="hidden" />

            @if (config('app.PAYMENT_VIA') == 'BrainTree' && isset($config['token']))
                <input id="nonce" name="payment_method_nonce" type="hidden" />

                <input id="package_id" name="package_id" type="hidden" value="{{ $package_id }}">
                <div class="bt-drop-in-wrapper">
                    <div id="bt-dropin"></div>
                </div>
            @endif

            <button class="btn btn-primary" type="submit"><span>Pay</span></button>
        </form>
    @endif
@endsection


@section('JS')
    @if (config('app.PAYMENT_VIA') == 'BrainTree' && isset($config['token']))
        <script src="https://js.braintreegateway.com/web/dropin/1.33.4/js/dropin.min.js"></script>
        <script>
            var form = document.querySelector('#payment-form');
            var client_token = "{{ $config['token'] }}";

            braintree.dropin.create({
                authorization: client_token,
                selector: '#bt-dropin',
                paypal: {
                    flow: 'vault'
                }
            }, function(createErr, instance) {
                if (createErr) {
                    console.log('Create Error', createErr);
                    return;
                }
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    instance.requestPaymentMethod(function(err, payload) {
                        if (err) {
                            console.log('Request Payment Method Error', err);
                            return;
                        }

                        // Add the nonce to the form and submit
                        document.querySelector('#nonce').value = payload.nonce;
                        form.submit();
                    });
                });
            });
        </script>
    @endif
@endsection
