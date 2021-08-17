<section class="footer-section">
	<div class="container">
		<div class="footer-logo text-center">
			<a href="/"><img src="" alt=""></a>
		</div>
		<div class="row">
			<div class="col-lg-3 col-sm-6">
				<div class="footer-widget about-widget">
					<h2>{{ trans('frontend.About us') }}</h2>
					<p>{{ $systemDetail->description }}</p>
					<img src="{{ asset('frontend/img/cards.png') }}" alt="">
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="footer-widget about-widget">
					<h2>{{ trans('frontend.Quick links') }}</h2>
					<ul>
						<li><a href="{{ route('about-us') }}">{{ trans('frontend.About Debjaz') }}</a></li>
						<li><a href="">{{ trans('frontend.My Account') }}</a></li>
						<li><a href="">{{ trans('frontend.Active Tickets') }}</a></li>
						<li><a href="{{ route('contact-us') }}">{{ trans('frontend.Campaigns') }}</a></li>
						<li><a href="{{ route('my-orders.index') }}">{{ trans('frontend.Products') }}</a></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="footer-widget about-widget">
					<h2>{{ trans('frontend.More') }}</h2>
					<div class="fw-latest-post-widget">
					<ul>
						<li><a href="{{ route('contact-us') }}">{{ trans('frontend.Contact Us') }}</a></li>
						<li><a href="{{ route('contact-us') }}">{{ trans('frontend.FAQs') }}</a></li>
						<li><a href="">{{ trans('frontend.How it Works') }}</a></li>
						<li><a href="{{ route('terms.conditions') }}">{{ trans('frontend.Charities') }}</a></li>
						<li><a href="{{ route('privacy.policy') }}">{{ trans('frontend.Campaign Draw Terms & Conditions') }}</a></li>

					</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="footer-widget contact-widget">
					<h2>{{ trans('frontend.CONTACT') }}</h2>
					<div class="con-info">
						<p>{{ $systemDetail->name }} </p>
					</div>
					<div class="con-info">
						<p>{{ $systemDetail->address }} </p>
					</div>
					<div class="con-info tel">
						<p>{{ $systemDetail->tel }}</p>
					</div>
					<div class="con-info">
						<p>{{ $systemDetail->email }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="social-links-warp">
		<div class="container">
			 class="container">
			@if($socialLinks != null)
			<div class="social-links">
				@if($socialLinks->instagram != null)
					<a href="{{$socialLinks->instagram}}" target="_blank" class="instagram"><i class="fab fa-instagram"></i><span>instagram</span></a>
				@endif
				@if($socialLinks->pinterest != null)
					<a href="{{$socialLinks->pinterest}}" target="_blank" class="pinterest"><i class="fab fa-pinterest"></i><span>pinterest</span></a>
				@endif
				@if($socialLinks->facebook != null)
					<a href="{{$socialLinks->facebook}}" target="_blank" class="facebook"><i class="fab fa-facebook-f"></i><span>facebook</span></a>
				@endif
				@if($socialLinks->twitter != null)
					<a href="{{$socialLinks->twitter}}" target="_blank" class="twitter"><i class="fab fa-twitter"></i><span>twitter</span></a>
				@endif
				@if($socialLinks->youtube != null)
					<a href="{{$socialLinks->youtube}}" target="_blank" class="youtube"><i class="fab fa-youtube"></i><span>youtube</span></a>
				@endif
				@if($socialLinks->linkedin != null)
					<a href="{{$socialLinks->linkedin}}" target="_blank" class="linkedin"><i class="fab fa-linkedin"></i><span>linkedin</span></a>
				@endif
				@if($socialLinks->tiktok != null)
					<a href="{{$socialLinks->tiktok}}" target="_blank" class="tiktok"><i class="fab fa-tiktok"></i><span>tiktok</span></a>
				@endif
			</div>
			@endif
			<p class="text-white text-center mt-5">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Developed By <a href="https://intellijapp.github.io/" target="_blank">Intellijapp</a></p>

		</div>
	</div>
</section>
