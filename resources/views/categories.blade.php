@extends('layouts.frontend')

@section('seo')

<title>{{ $systemInfo->name }} | Product Categories</title>
<meta charset="UTF-8">
<meta name="description" content="{{ $systemInfo->description }}">
<meta name="keywords" content="{{ $systemInfo->description }}, {{ $systemInfo->description }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{{ App::setLocale(session()->get('locale') ? session()->get('locale')  : "en") }}
<?php 
function color($x){
switch ($x) {
  case $x<=50:
    echo "border-primary";
    break;
  case $x>=50 &&  $x<75:
    echo "border-warning";
    break;
  case $x>=75 &&  $x<100:
    echo "border-danger";
    break;
  case $x==100:
      echo "border-success";
      break;
  default:
      echo "border-primary";
      break;
}
}
?>
@endsection

@section('content')

	<!-- Page info -->
	<div class="page-top-info">
		<div class="container">
			<h4>{{ trans('frontend.Campaigns') }}</h4>
			<div class="site-pagination">
				<a href="/">{{ trans('frontend.Home') }}</a> {{ trans('frontend./') }}
				<a href="">{{ trans('frontend.Shop') }}</a>
			</div>
		</div>
	</div>
	<!-- Page info end -->


	<!-- Category section -->
	<section class="category-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 order-2 order-lg-1">
					<div class="filter-widget">
						<h2 class="fw-title">{{ trans('frontend.Campaigns') }}</h2>
						<ul class="category-menu">
							@foreach($category as $cat)
								<li><a href="{{ route('frontendCategory', $cat->slug) }}">{{ $cat->name }}</a>
									@if($cat->subcategories->count() > 0)
									<ul class="sub-menu">
										@foreach($cat->subcategories as $sub)
											<li><a href="{{ route('subcategory', $sub->slug) }}">{{ $sub->name }}<span>({{ $sub->products->count() }})</span></a></li>
										@endforeach
									</ul>
									@endif
								</li>
							@endforeach
						</ul>
					</div>
					<div class="filter-widget mb-0">
						<h2 class="fw-title">{{ trans('frontend.Price') }}</h2>
						<div class="price-range-wrap">
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="10" data-max="270">
								<div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
								<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;">
								</span>
								<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;">
								</span>
							</div>
							<div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                        </div>
					</div>
				</div>

				<div class="col-lg-9  order-1 order-lg-2 mb-5 mb-lg-0">
						<div class="row">
						@foreach($products as $p)
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-item">
                        <div class="pi-pic">
                            @if($p->on_sale == 1)
                            <div class="tag-sale">ON SALE</div>
                            @endif
                            @if($p->is_new == 1)
                            <div class="tag-new">New</div>
                            @endif
                            <a href="{{ route('single-product', $p->slug) }}">
                                <a href="{{ route('single-product', $p->slug) }}">
                                @if($p->photos->count() > 0)
                                <div class="row">
                                    <div  class="col-md-4" >
                                    <img src="<?php echo env('APP_NAME') ?>{{ $p->photos->first()->images }} " alt="">
                                    </div>
                                    <div  class="col-md-4" >
                                    <div  style="  position: absolute;top: 30%;left: 35%;">
                                            <div  class="progress blue  mx-auto"   data-value='<?php echo $value = (100/$p->quantity)*($orderProduct->where('product_id',"=",$p->id)->sum('quantity'))?>' ><span class="progress-left"><span class="progress-bar <?php color($value); ?>"></span></span><span class="progress-right"><span class="progress-bar  <?php color($value); ?>"></span></span>
                                                <div class="progress-value"><?php echo ($orderProduct->where('product_id',"=",$p->id)->sum('quantity'))."/".(int)$p->quantity  ?></div>
                                            </div>
                                        <!--    <div class="progress yellow"> <span class="progress-left"> <span class="progress-bar"></span> </span> <span class="progress-right"> <span class="progress-bar"></span> </span>
                                                <div class="progress-value">37.5%</div>
                                            </div>-->
                                    </div>

                                    </div>
                                    <img class="col-md-4" src="<?php echo env('APP_NAME') ?>{{ $p->photos->last()->images }} " alt="">
                                    </div>
                                </div>

                                @else
                                    <img style="width:40%" src="{{ asset('frontend/img/no-image.png') }}" alt="">
                                @endif
                            </a>
                            </a>
                            <div class="pi-links" style="font-size: 30px;">
                                <form action="{{ route('cart.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$p->id}}">
                                    <input type="hidden" name="name" value="{{$p->name}}">
                                    <input type="hidden" name="price" value="{{$p->price}}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="add-card"><i class="flaticon-bag"></i><span style="font-size:14px;padding-top: 12px;">ADD TO CART</span></button>
                                </form>
                                <form action="{{ route('wishlist.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$p->id}}">
                                    <input type="hidden" name="name" value="{{$p->name}}">
                                    <input type="hidden" name="price" value="{{$p->price}}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="wishlist-btn"><i class="flaticon-heart"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="pi-text">
                            <h6>${{ $p->price }}</h6>
                            <p> {{ $p->name }} </p>
                        </div>
                    </div>
                </div>
                @endforeach
						</div>
						{{ $products->links() }}
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Category section end -->
	<script
  src="https://code.jquery.com/jquery-1.12.4.js"
  integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
  crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
$(".progress").each(function() {

  var value = $(this).attr('data-value');
  var left = $(this).find('.progress-left .progress-bar');
  var right = $(this).find('.progress-right .progress-bar');

  if (value > 0) {
    if (value <= 50) {
      right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
    } else {
      right.css('transform', 'rotate(180deg)')
      left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
    }
  }

})

function percentageToDegrees(percentage) {

  return percentage / 100 * 360

}
});

    </script>
@endsection
