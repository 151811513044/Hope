@extends('layouts.app')

@section('content')
<!-- toko start -->
<div class="popular-product-area wrapper-padding-3">
	<div class="container-fluid mb-5">
		<div class="section-title-6  text-left">
			@if(!Auth::user())
			<h2>
				<a href="{{url('/stores')}}/{{$prod->store_id}}">
					<i class="ti-home"></i> {{$store->name}}
				</a>
			</h2>
			@endif
			@if(Auth::user())
			<h2>
				<a href="{{url('/home/stores')}}/{{$prod->store_id}}">
					<i class="ti-home"></i> {{$store->name}}
				</a>
			</h2>
			@endif
		</div>
		<h5>{{$store->city->name}}</h5>
		<a href="https://api.whatsapp.com/send?phone={{$store->phone}}" class="btn btn-success btn-sm">Chat Penjual</a>
	</div>
</div>
<!-- end -->
<!-- Carousel Toko -->
<div class="catch-banner-area">
	<div class="container">
		<div class="catch-wrapper">
			<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner" style="background-color:cadetblue;">
					@foreach($carousels as $key => $carousel)
					<div class="carousel-item {{$key == 0 ? 'active' : '' }}">
						<img src="{{asset('storage/images/carousel/seller/'.$carousel->photo.'')}}" class="d-block" style="width: 1170px;; height:500px; object-fit:corner;" alt="...">
					</div>
					@endforeach
				</div>
				<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
</div>
<!-- End Carousel Toko -->
<!-- banner area start -->
<div class="banner-area pt-90 pb-160 fix">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-4">
				<div class="furits-banner-wrapper mb-30 wow fadeInLeft">
					<img src="asset('themes/ezone/assets/img/banner/40.jpg')" alt="">
					<div class="furits-banner-content">
						<h4>Super Natural</h4>
						<p>Lorem Ipsum is simply dummy text of the printing.</p>
						<a class="furits-banner-btn btn-hover" href="#">Shop Now</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- banner area end -->
<div class="shop-page-wrapper shop-page-padding ptb-100">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3">
				@include('layouts.store.sidebar')
			</div>
			<div class="col-lg-9">
				<div class="shop-product-wrapper res-xl">
					<div class="shop-bar-area">
						<div class="shop-bar pb-60">
							<div class="shop-found-selector">
								<div class="shop-found">

								</div>
							</div>
							<div class="shop-filter-tab">
								<div class="shop-tab nav" role=tablist>
									<a class="active" href="#grid-sidebar3" data-toggle="tab" role="tab" aria-selected="false">
										<i class="ti-layout-grid4-alt"></i>
									</a>
									<a href="#grid-sidebar4" data-toggle="tab" role="tab" aria-selected="true">
										<i class="ti-menu"></i>
									</a>
								</div>
							</div>
						</div>
						<div class="shop-product-content tab-content">
							<div id="grid-sidebar3" class="tab-pane fade active show">
								@include('layouts.store.grid_view')
							</div>
							<div id="grid-sidebar4" class="tab-pane fade">
								@include('layouts.store.list_view')
							</div>
						</div>
					</div>
				</div>
				<div class="mt-50 text-center">
					{{ $products->links() }}
				</div>
			</div>
		</div>
	</div>
</div>

@include('layouts.includes.modals')
@endsection