@extends('layouts.frontend')

@section('seo')

<title>Welcome To | {{ $systemName->name }}</title>
<meta charset="UTF-8">
<meta name="description" content="{{ $systemName->description }}">
<meta name="keywords" content="{{ $systemName->name }}, {{ $systemName->name }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@if( session()->get('locale')  == 'ar')
    <link href="{{ asset('frontend/css/allrtl.css') }}" rel="stylesheet">
	@endif
@endsection
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
{{ App::setLocale(session()->get('locale') ? session()->get('locale')  : "en") }}
@section('content')

  @if($slides->count() > 0)
    <!-- Hero section -->
    <section class="hero-section">
        <div class="hero-slider owl-carousel">
            @foreach($slides as $slide)
            <div class="hs-item set-bg" data-setbg="<?php echo env('APP_NAME') ?>{{ $slide->image }}">
                <div class="container">
                    <div class="row hero-section-row">
                        <div class="col-xl-12 col-lg-12 text-white">
                            <span>{{ $slide->heading }}</span>
                            <p>{{ Str::limit($slide->description, 100) }}</p>
                            <a href="/{{ $slide->link }}" class="site-btn sb-line">{{ trans('frontend.Buy') }}</a>
                            <a href="{{ route('contact-us') }}" class="inquire site-btn sb-white">{{ trans('frontend.More') }}</a>
                        </div>
                    </div>
                    @if($slide->from_price != null)
                    <div class="offer-card text-white">
                        <span>from</span>
                        <h3>${{ $slide->from_price}}</h3>
                        <p>SHOP NOW</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="container">
            <div class="slide-num-holder" id="snh-1"></div>
        </div>
    </section>
    <!-- Hero section end -->



    <!-- Features section -->
    <section class="features-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 p-0 feature">
                    <div class="feature-inner">
                        <div class="feature-icon">
                            <img src="{{ asset('frontend/img/icons/1.png') }}" alt="#">
                        </div>
                        <h4>{{ trans('frontend.Fast Secure Payments') }}</h4>
                    </div>
                </div>
                <div class="col-md-4 p-0 feature">
                    <div class="feature-inner">
                        <div class="feature-icon">
                            <img src="{{ asset('frontend/img/icons/2.png') }}" alt="#">
                        </div>
                        <h4 class="text-white">{{ trans('frontend.Premium Products') }}</h4>
                    </div>
                </div>
                <div class="col-md-4 p-0 feature">
                    <div class="feature-inner">
                        <div class="feature-icon">
                            <img src="{{ asset('frontend/img/icons/3.png') }}" alt="#">
                        </div>
                        <h4>{{ trans('frontend.Affordable Delivery') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Features section end -->
    @endif

  <!-- Product filter section -->
  <section class="product-filter-section">
        <div class="container">
            <div class="section-title">
              <br>
                <h3>{{ trans('frontend.BROWSE TOP SELLING PRODUCTS') }}</h3>
            </div>
            <ul class="product-filter-menu">
                @foreach($categories as $cat)
                    <li><a href="{{ route('frontendCategory', $cat->slug) }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
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
            @if($products->count() > 8)
                <div class="text-center pt-5">
                    <a href="{{ route('frontendCategories') }}" class="site-btn sb-line sb-dark">VIEW MORE</a>
                </div>
            @endif
        </div>
    </section>
    <!-- letest product section -->
    <section class="top-letest-product-section">
        <div class="container">
            <div class="section-title">
                <h3>{{ trans('frontend.LATEST PRODUCTS') }}</h3>
            </div>
            <div class="product-slider owl-carousel">
                @foreach($products as $p)
                <div class="product-item">
                    <div class="pi-pic">
                        @if($p->on_sale == 1)
                        <div class="tag-sale">ON SALE</div>
                        @endif
                        @if($p->is_new == 1)
                        <div class="tag-new">New</div>
                        @endif
                        <a href="{{ route('single-product', $p->slug) }}">
                            @if($p->photos->count() > 0)
                                <img src="<?php echo env('APP_NAME') ?>{{ $p->photos->first()->images }} " alt="">
                            @else
                                <img src="{{ asset('frontend/img/no-image.png') }}" alt="">
                            @endif
                        </a>
                        <div class="pi-links">
                            <form action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$p->id}}">
                                <input type="hidden" name="name" value="{{$p->name}}">
                                <input type="hidden" name="price" value="{{$p->price}}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></button>
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
                        <h3>${{ $p->price }}</h3>
                        <a href="{{ route('single-product', $p->slug) }}"><p>{{ $p->name }}</p></a> 
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- letest product section end -->



  
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
    <!-- Product filter section end -->

@endsection