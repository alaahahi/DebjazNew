@extends('layouts.frontend')

@section('seo')

<title>
	@if(auth()->check()) 
		{{ auth()->user()->name }} 's Orders
	@endif
</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $lang=session()->get('locale') ? session()->get('locale')  : "it" ?>
{{App::setLocale($lang) }}
@endsection

@section('content')

	<!-- cart section end -->
	<section class="cart-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="cart-table">
						<h3>{{ trans('frontend.My Orders') }}</h3>
						<div class="cart-table-warp">
							<table>
								<thead>
									<tr>
										<th class="size-col">{{ trans('frontend.Order Number') }}</th>
										<th class="size-col">{{ trans('frontend.Total Amount') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($orders as $order)
									<tr>
										<td class="size-col"><h4>{{ $order->order_number }}</h4></td>
										<td class="total-col"><h4>{{ $order->billing_total  * $currency->price}} <?php echo  $currency->currency ?> </h4></td>
										<td>
											<a href="{{ route('my-profile.show', $order->id) }}" class="btn btn-success btn-sm">{{ trans('frontend.View Order') }}</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							<div class="ml-3">
								<!--{{ $orders->links() }} -->
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 card-right">
					<a href="{{ route('my-profile.edit') }}" class="site-btn">{{ trans('frontend.Profile Settings') }}</a>
					<a href="{{ route('frontendCategories') }}" class="site-btn sb-dark">{{ trans('frontend.Continue shopping') }}</a>
				</div>
			</div>
		</div>
	</section>
	<!-- cart section end -->

	<!-- Related product section -->
<section class="related-product-section">
	<div class="container">
		<div class="section-title text-uppercase">
			<h2>{{ trans('frontend.YOU ALSO VIEWED') }}</h2>
		</div>
		<div class="row">
			@foreach($recentlyViewed as $view)
			<div class="col-lg-3 col-sm-6">
				<div class="product-item">
					<div class="pi-pic">
						<div class="tag-new">New</div>
						<a href="{{ route('single-product', $view->slug) }}">
							@if($view->photos->count() > 0)
                                <img src="<?php echo env('APP_NAME') ?>{{ $view->photos->first()->images }}" alt="">
                            @else
                                <img src="{{ asset('frontend/img/no-image.png') }}" alt="">
                            @endif
						</a>
						<div class="pi-links">
							<form action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$view->id}}">
                                <input type="hidden" name="name" value="{{$view->name}}">
								<input type="hidden" name="name_ar" value="{{$view->name_ar}}">
                                <input type="hidden" name="name_sw" value="{{$view->name_sw}}">
                                <input type="hidden" name="price" value="{{$view->price}}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="add-card"><i class="flaticon-bag"></i><span>{{ trans('frontend.Buy') }}</span></button>
                            </form>
                            <form>
                                <button type="submit" class="wishlist-btn"><i class="flaticon-heart"></i></button>
                            </form>
						</div>
					</div>
					<div class="pi-text">
						<h6>${{ $view->price * $currency->price}} <?php echo  $currency->currency ?></h6>
						<p>
						<?php if($lang=='it')
											{
												echo $view->name;
											}
											if($lang=='ar'){
												echo $view->name_ar;
											}
											if($lang=='en'){
												echo $view->name_en;
											}
											?>
						</p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
<!-- Related product section end -->

@endsection