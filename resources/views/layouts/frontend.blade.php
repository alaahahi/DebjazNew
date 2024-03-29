<!DOCTYPE html>
<html lang="zxx"> 
<head>
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

	@yield('seo')
	<!-- Favicon -->
	<link href=<?php echo env('APP_NAME') ?>{{$shareSettings->favicon}}" rel="shortcut icon"/>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="{{ asset('frontend/css/all.css') }}"/>
	@if( session()->get('locale')  == 'ar')
    <link href="{{ asset('frontend/css/allrtl.css') }}" rel="stylesheet">
	@endif

	<link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}"/>
	<!-- font-owesome icons link -->
    <link href="{{ asset('frontend/fontawesome/css/all.css') }}" rel="stylesheet">
	
	<livewire:styles />
	@yield('css')

	<!-- Global site tag (gtag.js) - Google Analytics -->
	@if($shareSettings->google_analytics != null)
	<script async src="https://www.googletagmanager.com/gtag/js?id={{ $shareSettings->google_analytics }}"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', '{{ $shareSettings->google_analytics }}');
	</script>
	@endif
</head>
<body>
<?php $lang=session()->get('locale') ? session()->get('locale')  : "it" ?>
{{App::setLocale($lang) }}
	<!-- Header section -->
	<header class="header-section">
		<div class="header-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2 text-center text-lg-left">
						<!-- logo -->
						<a href="<?php echo url("/") ?>" class="site-logo">
							<img src="<?php echo env('APP_NAME') ?>images\logo.png" alt="" width="150px">
						</a>
					</div>				
					<livewire:search-dropdown>
					<div class="col-sm-5" style="text-align: right;">
						<div class="user-panel">
							<div class="up-item">
								<div class="shopping-card">
									<i class="flaticon-heart"></i>
									@if(Cart::instance('wishlist')->count() != 0)
										<span>{{ Cart::instance('wishlist')->count() }}</span>
									@endif
								</div>
								<a href="{{ route('wishlist.index') }}">{{ trans('frontend.Wishlist') }}</a>
							</div>
							<div class="up-item">
								<div class="shopping-card">
									<i class="flaticon-bag"></i>
									<span>{{ Cart::instance('default')->count() }}</span>
								</div>
								<a href="{{ route('cart.index') }}">{{ trans('frontend.Cart') }}</a>
							</div>
							<div class="up-item">
							<select class="form-control" onchange="location = this.value;"> ?>
							@if(App::getLocale() == 'en')
							<option value="{{url('/setlocale/en')}}" selected>English</option>
							<option value="{{url('/setlocale/ar')}}">العربية</option>
							<option value="{{url('/setlocale/it')}}">Swidthis</option>
							@elseif(App::getLocale() == 'ar')
							<option value="{{url('/setlocale/ar')}}">العربية</option>
							<option value="{{url('/setlocale/en')}}">English</option>
							<option value="{{url('/setlocale/en')}}">Swidthis</option>
							@elseif(App::getLocale() == 'it')
							<option value="{{url('/setlocale/it')}}">Swidthis</option>
							<option value="{{url('/setlocale/ar')}}">العربية</option>
							<option value="{{url('/setlocale/en')}}">English</option>
							@endif
							</select>
							</div>
							<div class="up-item">
							<select class="form-control" onchange="location = this.value;"> ?>
							@if(session()->get('currency') == 'sek'  || session()->get('currency')==null)
							<option value="{{url('/setcurrency/sek')}}" selected>SEK</option>
							<option value="{{url('/setcurrency/usd')}}">USD</option>
							<option value="{{url('/setcurrency/eur')}}">EUR</option>
							@endif
							@if(session()->get('currency') == 'usd')
							<option value="{{url('/setcurrency/sek')}}">SEK</option>
							<option value="{{url('/setcurrency/usd')}}" selected>USD</option>
							<option value="{{url('/setcurrency/eur')}}">EUR</option>
							@endif
							@if(session()->get('currency') == 'eur')
							<option value="{{url('/setcurrency/usd')}}">SEK</option>
							<option value="{{url('/setcurrency/sek')}}">USD</option>
							<option value="{{url('/setcurrency/eur')}}" selected>EUR</option>
							@endif
							</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<livewire:nav-bar>
	</header>
	<!-- Header section end -->
	<div id="app">
	<example-component></example-component>
</div>
	@yield('content')


	<!-- Footer section -->
	<livewire:footer-detail>
	<!-- Footer section end -->



	<!--====== Javascripts & Jquery ======-->
	

	


	<script src="{{ asset('frontend/js/alls.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	
	<script src="{{ asset('js/toastr.js') }}"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js" integrity="sha512-PDFb+YK2iaqtG4XelS5upP1/tFSmLUVJ/BVL8ToREQjsuXC5tyqEfAQV7Ca7s8b7RLHptOmTJak9jxlA2H9xQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script>
	    @if(Session::has('success'))
	    toastr.success("{{ Session::get('success')}}")
	    @endif
	</script>
	<script>
	    @if(Session::has('error'))
	    toastr.error("{{ Session::get('error')}}")
	    @endif
	</script>

	@yield('scripts')
	
	</body>	
	
</html>
