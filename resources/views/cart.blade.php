@extends('layouts.frontend')

@section('seo')

<title>
	@if(auth()->check()) 
		{{ auth()->user()->name }} 's Cart
	@else
		Cart
	@endif
</title>
<meta charset="UTF-8">
<meta name="description" content="{{ $systemInfo->description }}">
<meta name="keywords" content="{{ $systemInfo->description }}, {{ $systemInfo->description }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $lang=session()->get('locale') ? session()->get('locale')  : "it" ?>
{{App::setLocale($lang) }}
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/4.0.0-alpha.1/css/bootstrap-switch.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/4.0.0-alpha.1/js/bootstrap-switch.js"></script>
@endsection

@section('content')
<?php function  donet () { echo "checked"; } ?>
<!-- cart section end -->
<section class="cart-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="cart-table">
					<h3>{{ trans('frontend.Cart') }}</h3>
					<div class="cart-table-warp">
						<table>
						<thead>
							<tr>
								<th class="product-th">{{ trans('frontend.Product') }}</th>
								<th class="quy-th">{{ trans('frontend.Quantity') }}</th>
								<th class="quy-th">{{ trans('frontend.Cards Lottery') }}</th>
								<th class="total-th">{{ trans('frontend.Price') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach(Cart::content() as $item)
							<tr>
								<td class="product-col">
								<!--
									<a href="{{ route('single-product', $item->model->slug) }}">
										@if($item->model->photos->count() > 0)
			                               <img src="{{ asset('$item->model->photos->first()->images') }}" alt="">
			                            @else
			                                <img src="{{ asset('frontend/img/no-image.png') }}" alt="">
			                            @endif
									</a>
-->
									<div class="pc-title">
									<h4>	<?php if($lang=='it')
											{
												echo $item->model->name_sw;
											}
											if($lang=='ar'){
												echo $item->model->name_ar;
											}
											if($lang=='en'){
												echo $item->model->name;
											}
											?>
									</h4>
										<p>{{ $item->model->price * $currency->price}} <?php echo  $currency->currency ?></p>
									</div>
								</td>
								<td class="quy-col">
									<div class="quantity">
										<form action="{{ route('cart.update', $item->rowId) }}" method="post">
											@csrf
											@method('PATCH')
											<div class="pro-qty">
												<input type="text" name="quantity" value="{{$item->qty}}">
											</div>
											<button style="border: none;">
												<i class="cancel fas fa-check ml-2" title="Update Product Qty" style="cursor: pointer; color: #00FF00;"></i>
											</button>
										</form>
                					</div>
								</td>
								<td style="text-align: center;">
									<input name="card" style="text-align: center;width:76px;height: 36px; border: 1px solid #fff;padding: 0 15px;background-color: white; border-radius: 40px;" type="text" class="quant" value="{{$item->card}}" disabled>
								</td>
								<td class="total-col"><h4>{{ $item->subtotal * $currency->price}}<?php echo  $currency->currency ?></h4></td>
								<td class="total-col">
									<form action="{{ route('cart.destroy', $item->rowId) }}" method="post">
										@csrf
										@method('DELETE')
										<button style="border: none;">
											<i class="cancel fas fa-times" title="Remove Product" style="cursor: pointer; color: #f51167;"></i>
										</button>
									</form>
								</td>
							</tr>
							@endforeach
							@if(session()->get('coupon') != null)
							<tr>
								<td>Discount ({{session()->get('coupon')['name']}})</td>
								<td>
									<form action="{{ route('coupons.destroy') }}" method="post">
										@csrf
										@method('DELETE')
										<button style="border: none;">
											<i class="cancel fas fa-times" title="Remove coupon" style="cursor: pointer; color: #f51167;"></i>
										</button>
									</form>
								</td>
								<td></td>
								<td>- ${{session()->get('coupon')['discount']}}</td>
							</tr>
							<tr>
								<td><strong>New Subtotal</strong></td>
								<td></td>
								<td></td>
								<td><strong>$ {{$newSubtotal}}</strong></td>
							</tr>
							@endif
						</tbody>
					</table>
					</div>
					<div class="total-cost">
						<h6>{{ trans('frontend.Total Amount') }}<span style="padding: 0 20px ;font-size: 28px;">{{ $newTotal * $currency->price}}<?php echo  $currency->currency ?></span></h6>
					</div>
				</div>
			</div>
			<div class="col-lg-4 card-right">
				<!-- @if(! session()->has('coupon'))
				<form action="{{ route('coupons.store') }}" class="promo-code-form" method="post">
					@csrf
					<input type="text" name="coupon_code" id="coupon_code" placeholder="Enter promo code">
					<button type="submit">Submit</button>
				</form>
				@endif
-->
			<div class="checkbox">
			<label>
			</label>
			</div>
			<div class="text-center">
				<input type="checkbox" name="my-checkbox" checked data-on-color="success" data-switch-value="small" data-on-text="{{ trans('frontend.Donated') }}" data-off-text="{{ trans('frontend.Deliverable') }}">
				<h6 class="Donate" style="color: #5cb85c; font-weight: bold;padding: 10px;">
				{{ trans('frontend.Donate to receive an additional entry!') }}
				</h6>
				<p class="agree">
				{{ trans("frontend.I agree to donate all purchased products to charity as per the") }}
				</p>
				<br>
				<a href="{{ route('checkout.index') }}" class="site-btn">{{ trans('frontend.Proceed to checkout') }}</a>
				<a href="{{ route('frontendCategories') }}" class="site-btn sb-dark">{{ trans('frontend.Continue shopping') }}</a>
			</div>
			</div>
		</div>
	</div>
</section>
<!-- cart section end -->

<!-- Related product section -->
<section class="related-product-section">
	<div class="container">
		<div class="section-title text-uppercase">
			<h2>{{ trans('frontend.MIGHT ALSO LIKE') }}</h2>
		</div>
		<div class="row">
			@foreach($mightAlsoLike as $like)
			<div class="col-lg-3 col-sm-6">
				<div class="product-item">
					<div class="pi-pic">
						@if($like->on_sale == 1)
                        <div class="tag-sale">ON SALE</div>
                        @endif
                        @if($like->is_new == 1)
                        <div class="tag-new">New</div>
                        @endif
						<a href="{{ route('single-product', $like->slug) }}">
							@if($like->photos->count() > 0)
                                <img src="<?php echo env('APP_NAME') ?>{{ $like->photos->first()->images }}" alt="">
                            @else
                                <img src="{{ asset('frontend/img/no-image.png') }}" alt="">
                            @endif
						</a>
						<div class="pi-links">
							<form action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$like->id}}">
                                <input type="hidden" name="name" value="{{$like->name}}">
								<input type="hidden" name="name_ar" value="{{$like->name_ar}}">
                                <input type="hidden" name="name_sw" value="{{$like->name_sw}}">
                                <input type="hidden" name="price" value="{{$like->price}}">
								<input type="hidden" name="card" value="1">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="add-card"><i class="flaticon-bag"></i><span>{{ trans('frontend.Buy') }}</span></button>
                            </form>
                            <form action="{{ route('wishlist.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$like->id}}">
                                <input type="hidden" name="name" value="{{$like->name}}">
								<input type="hidden" name="name_ar" value="{{$like->name_ar}}">
                                <input type="hidden" name="name_sw" value="{{$like->name_sw}}">
                                <input type="hidden" name="price" value="{{$like->price}}">
								<input type="hidden" name="card" value="1">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="wishlist-btn"><i class="flaticon-heart"></i></button>
                            </form>
						</div>
					</div>
					<div class="pi-text">
						<h6><?php echo  $currency->currency ?>{{ $like->price * $currency->price}} <?php echo  $currency->currency ?></h6>
						<p>{{ $like->name }}</p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
<script>
	var $q =$('.quant').val();
	$("[name='my-checkbox']").bootstrapSwitch();
	$('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
	if(state){
		$('.Donate').text("{{ trans('frontend.Donate to receive an additional entry!') }}");
		$('.agree').text("{{ trans('frontend.I agree to donate all purchased products to charity as per the') }}");
		$('.quant').val($q);
	}
	if(!state){
		$('.Donate').text("{{ trans('frontend.Deliverable') }}");
		$('.agree').text("");
		$('.quant').val($q/2);
	}
	$('.loto').val();
});
</script>
@endsection
