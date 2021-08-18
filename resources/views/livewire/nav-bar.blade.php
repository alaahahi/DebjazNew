<nav class="main-navbar">
	<div class="container">
		<!-- menu -->
		<ul class="main-menu">
			<li><a href="<?php echo url("/")?>">{{ trans('frontend.Home') }}</a></li>
			<li><a href="{{ route('frontendCategories') }}">{{ trans('frontend.Shop') }}</a>
					<!-- 
				<ul class="sub-menu">
					@foreach($navCategories as $cat)
						<li><a href="{{ route('frontendCategory', $cat->slug) }}">{{ $cat->name }}</a></li>
					@endforeach	
				</ul>
				 -->
			</li>
			<li><a href="{{ route('on-sale') }}">{{ trans('frontend.Campaigns') }}
				<span class="new">Sale</span>
			</a></li>
			<li><a href="#">{{ trans('frontend.About us') }}</a></li>
			<li><a href="#">{{ trans('frontend.Help Center') }}</a></li>
			<li><a href="{{ route('contact-us') }}">{{ trans('frontend.Contact Us') }}</a></li>
			@auth
			<li><i class="flaticon-profile mr-2  text-light"></i><a href="#">{{ auth()->user()->name }}</a>
				<ul class="sub-menu">
					<li><a href="{{ route('my-profile.edit') }}">{{ trans('frontend.Settings') }}</a></li>
					<li><a href="{{ route('my-orders.index') }}">{{ trans('frontend.My Orders') }}</a></li>
					@if(auth()->user()->isAdmin())
					<li><a href="{{ route('home') }}" target="_blank">{{ trans('frontend.Admin Dashboard') }}</a></li>
					@endif
					<li>
						<a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                           {{ trans('frontend.Sign Out') }}
                        </a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
					</li>
				</ul>
			</li>
			@else
			<li><a href="{{ route('login') }}">{{ trans('frontend.Sign In') }}</a></li>
			<li> <a href="{{ route('register') }}">{{ trans('frontend.Sign Up') }}</a></li>
			@endauth
		</ul>
	</div>
</nav>
