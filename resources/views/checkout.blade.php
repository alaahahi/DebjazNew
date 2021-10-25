@extends('layouts.frontend')

@section('seo')

<title>{{ $systemInfo->name }} | Checkout</title>
<meta charset="UTF-8">
<meta name="description" content="{{ $systemInfo->description }}">
<meta name="keywords" content="{{ $systemInfo->description }}, {{ $systemInfo->description }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@if(env('Dintero_API_SECRET') != null)
<script crossorigin="anonymous" src="https://unpkg.com/@dintero/checkout-web-sdk@0.0.17/dist/dintero-checkout-web-sdk.umd.min.js" integrity="sha384-C+s7429Bxo4cmt8Tt3N5MRR4fZ/OsEBHDJaHwOnhlizydtc7wgCGvH5u5cXnjSSx"></script>
@endif
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<?php $lang=session()->get('locale') ? session()->get('locale')  : "it" ?>
{{App::setLocale($lang) }}
<style type="text/css">
         .panel-title {
         display: inline;
         font-weight: bold;
         }
         .display-table {
         display: table;
         }
         .display-tr {
         display: table-row;
         }
         .display-td {
         display: table-cell;
         vertical-align: middle;
         width: 61%;
         }
		 .hide{
			 display: none;
		 }
      </style>
@endsection

@section('content')

<!-- checkout section  -->
<section class="checkout-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 order-2 order-lg-1">
			<form 	role="form"	action="{{ route('stripe.post') }}"
											method="post"
											class="require-validation checkout-form"
											data-cc-on-file="false"
											data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
											id="payment-form">
											@csrf
				<!--<form class="checkout-form" action="{{ route('checkout.store') }}" method="post">
					</form>-->
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
					<div id="accordion">
					@if(env('STRIPE_KEY') != null)
					<div class="card ">
						<div class="card-header" id="headingOne">
						<h5 class="mb-0 ">
							<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							{{ trans('frontend.Payment cards') }}
							</button>
						</h5>
						</div>

						<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
						<div class="card-body">
						<div class="container">
							<div class="row">
								<div class="col-md-12 text-center">
									<div >
										@if (Session::has('success'))
										<div class="alert alert-success text-center">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
											<p>{{ Session::get('success') }}</p>
										</div>
										@endif

											<div class='col-xs-12 form-group required'>
												<label class='control-label'>{{ trans('frontend.Name on Card') }}</label> <input
													class='form-control' size='12' type='text'>
											</div>
											<div class='col-xs-12 form-group required'>
												<label class='control-label'>{{ trans('frontend.Card Number') }}</label> <input
													autocomplete='off' class='form-control card-number' size='20'
													type='text'>
											</div>
											<div class='form-row row'>
											<div class='col-xs-12 col-md-4 form-group cvc required'>
												<label class='control-label'>CVC</label> <input autocomplete='off'
													class='form-control card-cvc'  placeholder='ex. 311' size='4'
													type='number'>
											</div>
											<div class='col-xs-12 col-md-4 form-group expiration required'>
												<label class='control-label'>{{ trans('frontend.Expiration Month') }}</label> <input
													class='form-control card-expiry-month' placeholder='MM' size='2'
													type='number'>
											</div>
											<div class='col-xs-12 col-md-4 form-group expiration required'>
												<label class='control-label'>{{ trans('frontend.Expiration Year') }}</label> <input
													class='form-control card-expiry-year' placeholder='YYYY' size='4'
													type='number'>
											</div>
											</div>
											<div class='form-row row'>
											<div class='col-md-12 error form-group hide' >
												<div class='alert-danger alert '>{{ trans('frontend.Please correct the errors and try again.') }}
												</div>
											</div>
											</div>
									</div>
								</div>
							</div>
						</div>
						</div>
						</div>
					</div>
					@endif
					@if(env('PAYPAL_SANDBOX_API_SECRET') != null)
					<div class="card">
						<div class="card-header" id="headingTwo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							Paypal
							</button>
						</h5>
						</div>
						<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
						<div class="card-body">
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
						</div>
						</div>
					</div>
					@endif
					@if(env('Dintero_API_SECRET') != null)
					<div class="card">
						<div class="card-header" id="headingThree">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
							Dintero
							</button>
						</h5>
						</div>
						<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
						<div class="card-body">
						<div id="checkout-container"> <img src="https://backoffice.dintero.com/api/checkout/v1/branding/profiles/T11113099.55zmdrmcMJakno7aqiet3W/variant/colors/width/420/dintero_top_frame.svg"></img> </div>
						</div>
						</div>
					</div>
					@endif
					@if(false)
					<div class="card">
						<div class="card-header" id="headingThree">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
							Cash on delivery
							</button>
						</h5>
						</div>
						<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
						<div class="card-body">
						
						</div>
						</div>
					</div>
					@endif
					</div>				
					<button type="submit" class="site-btn submit-order-btn">{{ trans('frontend.Place Order') }}</button>

			</div>
			</form>
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
							<h6><?php if($lang=='it')
											{
												echo $item->model->name;
											}
											if($lang=='ar'){
												echo $item->model->name_ar;
											}
											if($lang=='en'){
												echo $item->model->name_en;
											}
											?></h6>
							<p><?php echo  $currency->currency ?> {{ $item->subtotal  * $currency->price}}</p>
							<p>Qty {{ $item->qty }}</p>
						</li>
						@endforeach
					</ul>
					<ul class="price-list">
						<li>{{ trans('frontend.Total') }}<span><?php echo  $currency->currency ?> {{ $newSubtotal * $currency->price}} .00</span></li>
						<li>{{ trans('frontend.Shipping') }}<span>{{ trans('frontend.Free') }}</span></li>
						<li class="total">{{ trans('frontend.Total') }}<span><?php echo  $currency->currency ?> {{ $newTotal  * $currency->price}} .00</span></li>
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
@if(env('STRIPE_KEY') != null)
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
   <script type="text/javascript">
      $(function() {
    var $form = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]',
                'input[type=text]', 'input[type=file]',
                'textarea'
            ].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
        $errorMessage.addClass('hide');
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
            }
        });
        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
			$form.append("<input type='hidden' name='amount' value='" + {{ $newSubtotal }} + "'/>");
            $form.get(0).submit();
        }
    }
});
   </script>
<!-- checkout section end -->
@endif
@if(env('Dintero_API_SECRET') != null)
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
@endif
@if(env('PAYPAL_SANDBOX_API_SECRET') != null)
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
@endif
@endsection