@extends('layouts.internal')

@php

if ($response['status']) {
    $header = 'Payment Successful!';
    $icon = 'success';
    $message = 'Your transaction has been successfully processed for the amount <b> ' . $response['amount'] . '</b>, Here is the transaction id for your reference ' . $response['id'];
} elseif ($response['status'] == false && isset($response['id'])) {
    $header = 'Transaction Failed';
    $icon = 'fail';
    $message = 'Your transaction is Failed processed for the amount ' . $response['amount'] . ', Here is the transaction id for your reference ' . $response['id'];
} else {
    $header = 'Transaction Failed';
    $icon = 'fail';
    $message = 'Your transaction has a status of ' . $transaction->status . '. See the Braintree API response and try again.';
}

@endphp


@section('content')
    <div class="wrapper" style="
    margin-top: 10%;
">
        <div class="response container">
            <div class="content">
                <div class="icon">
                    <img src="/img/<?php echo $icon; ?>.svg" alt="">
                </div>

                <h1><?php echo $header; ?></h1>
                <section>
                    <p><?php echo $message; ?></p>
                </section>
                <section>
                    <a class="button primary back" href="/home">
                        <span>Home</span>
                    </a>
                </section>
            </div>
        </div>
    </div>
@endsection
