@extends('layouts.frontend')

@section('seo')

<title>{{ $systemInfo->name }} | Checkout</title>
<meta charset="UTF-8">
<meta name="description" content="{{ $systemInfo->description }}">
<meta name="keywords" content="{{ $systemInfo->description }}, {{ $systemInfo->description }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script crossorigin="anonymous" src="https://unpkg.com/@dintero/checkout-web-sdk@0.0.17/dist/dintero-checkout-web-sdk.umd.min.js" integrity="sha384-C+s7429Bxo4cmt8Tt3N5MRR4fZ/OsEBHDJaHwOnhlizydtc7wgCGvH5u5cXnjSSx"></script>
{{ App::setLocale(session()->get('locale') ? session()->get('locale')  : "en") }}
@endsection

@section('content')

<!-- checkout section  -->
<section class="checkout-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 order-2 order-lg-1">
				<form class="checkout-form" action="{{ route('checkout.store') }}" method="post">
					@csrf
					<div class="cf-title">{{ trans('frontend.Billing Address') }}</div>
					<div class="row">
						<div class="col-md-7">
							<p>{{ trans('frontend.Billing Information') }}</p>
						</div>
						<div class="col-md-5">
							<div class="cf-radio-btns address-rb">
								<div class="cfr-item">
									<input type="radio" name="pm" id="one">
									<label for="one">{{ trans('frontend.Use my regular address') }}</label>
								</div>
								<div class="cfr-item">
									<input type="radio" name="pm" id="two">
									<label for="two">{{ trans('frontend.Use a different address') }}</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row address-inputs">
						<div class="col-md-6">
							<input type="text" name="billing_fullname" placeholder="{{ trans('frontend.Full Name') }}" value="{{ auth()->user()->name }}">
						</div>
						<div class="col-md-6">
							<input type="text" name="billing_email" placeholder="{{ trans('frontend.Email') }}" value="{{ auth()->user()->email }}">
						</div>
						<div class="col-md-12">
							<input type="text" name="billing_address" placeholder="{{ trans('frontend.Address') }}"  value="{{ auth()->user()->address }}">
						</div>
						<div class="col-md-6">
							<input type="text" name="billing_city" placeholder="{{ trans('frontend.City') }}" value="{{ auth()->user()->city }}">
						</div>
						<div class="col-md-6">
							<input type="text" name="billing_province" placeholder="{{ trans('frontend.Province or State') }}" value="{{ auth()->user()->province }}">
						</div>
						<div class="col-md-6">
							<input type="text" name="billing_zipcode" placeholder="{{ trans('frontend.Zip code') }}"  value="{{ auth()->user()->zipcode }}">
						</div>
						<div class="col-md-6">
							<input type="text" name="billing_phone" placeholder="{{ trans('frontend.Phone') }}" value="{{ auth()->user()->phone }}">
						</div>
						<div class="col-md-12">
							<input type="text" name="notes" placeholder="{{ trans('frontend.Notes. Eg on delivery hoot or beep, am available Monday to Friday 7am to 7pm') }}" value="{{ auth()->user()->notes }}">
						</div>
					</div>
					{{-- <div class="cf-title">{{ trans('frontend.Delivery Info') }}</div>
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
					<div class="cf-title">{{ trans('frontend.Payment') }}</div>
						<ul class="payment-list">
							
							@if(env('PAYPAL_SANDBOX_API_SECRET') != null)
							<li>
								<input type="radio" name="payment_method" value="paypal">
								Paypal<a href="#"><img src="{{ asset('frontend/img/paypal.png') }}" alt=""></a>
							</li>
							@endif
							<li>
							<div id="smart-button-container">
      <div style="text-align: center;">
        <div style="margin-bottom: 1.25rem;">
          <p></p>
          <select id="item-options"><option value="" price="0"> - 0 USD</option></select>
          <select style="visibility: hidden" id="quantitySelect"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option></select>
        </div>
      <div id="paypal-button-container"></div>
      </div>
    </div>
							</li>
							{{-- <li>Credit / Debit card<a href="#"><img src="{{ asset('frontend/img/mastercart.png') }}" alt=""></a>
							</li> --}}
							<li>
								<input type="radio" name="payment_method" value="cash_on_delivery">
								cash_on_delivery
							</li>
							<li>
							<div id="checkout-container"> <img src="https://backoffice.dintero.com/api/checkout/v1/branding/profiles/T11113099.55zmdrmcMJakno7aqiet3W/variant/colors/width/420/dintero_top_frame.svg"></img> </div>
							</li>
						</ul>
					<button type="submit" class="site-btn submit-order-btn">Place Order</button>
				</form>
			</div>
			<div class="col-lg-4 order-1 order-lg-2">
				<div class="checkout-cart">
					<h3>{{ trans('frontend.Cart') }}</h3>
					<ul class="product-list">
						@foreach(Cart::content() as $item)
						<li>
							<div class="pl-thumb">
								@if($item->model->photos->count() > 0)
	                                <img src="{{ $item->model->photos->first()->images }}" alt="">
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
						<li>{{ trans('frontend.Total') }}<span>${{ $newSubtotal }}.00</span></li>
						<li>{{ trans('frontend.Shipping') }}<span>{{ trans('frontend.Free') }}</span></li>
						<li class="total">{{ trans('frontend.Total') }}<span>${{ $newTotal }}.00</span></li>
					</ul>
				</div>
				<div id="smart-button-container">
      <div style="text-align: center;">
        <div id="paypal-button-container"></div>
      </div>
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


  <script src="https://www.paypal.com/sdk/js?client-id=AaqzAhQhbTpvd-6P7-Vgj26JNgu63CS8etFcLX6h2Z89LW1AEGSGvWIXSDB71HKanLrx3XL4XKk-613B&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
  <script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'pill',
          color: 'blue',
          layout: 'vertical',
          label: 'paypal',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"amount":{"currency_code":"USD","value":1}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
            
            // Full available details
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

            // Show a success message within this page, e.g.
            const element = document.getElementById('paypal-button-container');
            element.innerHTML = '';
            element.innerHTML = '<h3>Thank you for your payment!</h3>';

            // Or go to another URL:  actions.redirect('thank_you.html');
            
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
  </script>

@endsection