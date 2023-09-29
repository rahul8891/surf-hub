@extends('layouts.user.new_layout')
@section('content')
<section class="home-section">

    <div class="container">
        <div class="mb-4">
            <a href="#" class="back-btn">
                <a class="align-middle" href="{{ route('uploadAdvertisment', Crypt::encrypt($post_id)) }}"">
                    <img src="/img/back-btn.png" alt="back" class="align-middle">

                    Edit Ads</a>
            </a>
        </div>
        <div class="middle-content">
                <div class="upload-wrap upload-preview">
                    

                    <div class="upload-body">
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
        </div>
    </div>
</section>

<script src="https://www.paypal.com/sdk/js?client-id=<?php echo config('paypal.sandbox.client_id') ?>&currency=USD"></script>

    <script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({
 // Call your server to set up the transaction
             createOrder: function(data, actions) {
                return fetch('/api/paypal/order/create', {
                    method: 'POST',
                    body:JSON.stringify({
                        'user_id' : "{{auth()->user()->id}}",
                        'amount' : '{{$amount}}',
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    return orderData.id;
                });
            },

            // Call your server to finalize the transaction
            onApprove: function(data, actions) {
                return fetch('/api/paypal/order/capture' , {
                    method: 'POST',
                    body :JSON.stringify({
                        orderId : data.orderID,
                        payment_gateway_id: $("#payapalId").val(),
                        user_id: "{{ auth()->user()->id }}",
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {

                    // Successful capture! For demo purposes:
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    iziToast.success({
                        title: 'Success',
                        message: 'Payment completed',
                        position: 'topRight'
                    });
                    window.location.href = "{{ route('myhub')}}";

                });
            }

        }).render('#paypal-button-container');
    </script>
@endsection