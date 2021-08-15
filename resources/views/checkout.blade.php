@extends('layouts.frontend')

@section('seo')

<title>{{ $systemInfo->name }} | Checkout</title>
<meta charset="UTF-8">
<meta name="description" content="{{ $systemInfo->description }}">
<meta name="keywords" content="{{ $systemInfo->description }}, {{ $systemInfo->description }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script crossorigin="anonymous" src="https://unpkg.com/@dintero/checkout-web-sdk@0.0.17/dist/dintero-checkout-web-sdk.umd.min.js" integrity="sha384-C+s7429Bxo4cmt8Tt3N5MRR4fZ/OsEBHDJaHwOnhlizydtc7wgCGvH5u5cXnjSSx"></script>

@endsection

@section('content')

<!-- checkout section  -->
<section class="checkout-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 order-2 order-lg-1">
				<form class="checkout-form" action="{{ route('checkout.store') }}" method="post">
					@csrf
					<div class="cf-title">Billing Address</div>
					<div class="row">
						<div class="col-md-7">
							<p>*Billing Information</p>
						</div>
						<div class="col-md-5">
							<div class="cf-radio-btns address-rb">
								<div class="cfr-item">
									<input type="radio" name="pm" id="one">
									<label for="one">Use my regular address</label>
								</div>
								<div class="cfr-item">
									<input type="radio" name="pm" id="two">
									<label for="two">Use a different address</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row address-inputs">
						<div class="col-md-6">
							<input type="text" name="billing_fullname" placeholder="Full Name" value="{{ auth()->user()->name }}">
						</div>
						<div class="col-md-6">
							<input type="text" name="billing_email" placeholder="Email" value="{{ auth()->user()->email }}">
						</div>
						<div class="col-md-12">
							<input type="text" name="billing_address" placeholder="Address"  value="{{ auth()->user()->address }}">
						</div>
						<div class="col-md-6">
							<input type="text" name="billing_city" placeholder="City" value="{{ auth()->user()->city }}">
						</div>
						<div class="col-md-6">
							<input type="text" name="billing_province" placeholder="Province or State" value="{{ auth()->user()->province }}">
						</div>
						<div class="col-md-6">
							<input type="text" name="billing_zipcode" placeholder="Zip code"  value="{{ auth()->user()->zipcode }}">
						</div>
						<div class="col-md-6">
							<input type="text" name="billing_phone" placeholder="Phone no." value="{{ auth()->user()->phone }}">
						</div>
						<div class="col-md-12">
							<input type="text" name="notes" placeholder="Notes. Eg on delivery hoot or beep, am available Monday to Frinday 7am to 7pm" value="{{ auth()->user()->notes }}">
						</div>
					</div>
					{{-- <div class="cf-title">Delievery Info</div>
					<div class="row shipping-btns">
						<div class="col-6">
							<h4>Standard</h4>
						</div>
						<div class="col-6">
							<div class="cf-radio-btns">
								<div class="cfr-item">
									<input type="radio" name="shipping" id="ship-1">
									<label for="ship-1">Free</label>
								</div>
							</div>
						</div>
						<div class="col-6">
							<h4>Next day delievery  </h4>
						</div>
						<div class="col-6">
							<div class="cf-radio-btns">
								<div class="cfr-item">
									<input type="radio" name="shipping" id="ship-2">
									<label for="ship-2">$3.45</label>
								</div>
							</div>
						</div> --}}
					{{-- </div> --}}
					<div class="cf-title">Payment</div>
						<ul class="payment-list">
							@if(env('PAYPAL_SANDBOX_API_SECRET') != null)
							<li>
								<input type="radio" name="payment_method" value="paypal">
								Paypal<a href="#"><img src="{{ asset('frontend/img/paypal.png') }}" alt=""></a>
							</li>
							@endif
							{{-- <li>Credit / Debit card<a href="#"><img src="{{ asset('frontend/img/mastercart.png') }}" alt=""></a>
							</li> --}}
							<li>
								<input type="radio" name="payment_method" value="cash_on_delivery">
								<div id="checkout-container"> <img src="https://backoffice.dintero.com/api/checkout/v1/branding/profiles/T11113099.55zmdrmcMJakno7aqiet3W/variant/colors/width/420/dintero_top_frame.svg"></img> </div>
							</li>
						</ul>
					<button type="submit" class="site-btn submit-order-btn">Place Order</button>
				</form>
			</div>
			<div class="col-lg-4 order-1 order-lg-2">
				<div class="checkout-cart">
					<h3>Your Cart</h3>
					<ul class="product-list">
						@foreach(Cart::content() as $item)
						<li>
							<div class="pl-thumb">
								@if($item->model->photos->count() > 0)
	                                <img src="https://localhost/ZimCart/storage/app/public/{{ $item->model->photos->first()->images }}" alt="">
	                            @else
	                                <img src="{{ asset('frontend/img/no-image.png') }}" alt="">
	                            @endif
							</div>
							<h6>{{ $item->model->name }}</h6>
							<p>${{ $item->subtotal }}</p>
							<p>Qty {{ $item->qty }}</p>
						</li>
						@endforeach
					</ul>
					<ul class="price-list">
						<li>Total<span>${{ $newSubtotal }}.00</span></li>
						<li>Shipping<span>free</span></li>
						<li class="total">Total<span>${{ $newTotal }}.00</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- checkout section end -->
<script type="text/javascript">
    const container = document.getElementById("checkout-container");
    dintero
        .embed({
            container,
            sid: "T11113099.55rjJtC4NUfpHDTa8P6op4",
            language: "no", 
            onSession: function(event, checkout) {
                console.log("session", event.session);
            },
            onPayment: function(event, checkout) {
                console.log("transaction_id", event.transaction_id);
                console.log("href", event.href);
                checkout.destroy();
            },
            onPaymentError: function(event, checkout) {
                console.log("href", event.href);
                checkout.destroy();
            },
            onSessionCancel: function(event, checkout) {
                console.log("href", event.href);
                checkout.destroy();
            },
            onSessionLocked: function(event, checkout) {
                console.log("pay_lock_id", event.pay_lock_id);
            },
            onSessionLockFailed: function(event, checkout) {
                console.log("session lock failed");
            },
            onActivePaymentType: function(event, checkout) {
                console.log("payment product type selected", event.payment_product_type);
            },
        })
        .then(function(checkout) {
            console.log("checkout", checkout);
        });
</script>

@endsection