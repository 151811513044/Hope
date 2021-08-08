<div class="shop-sidebar mr-50">
	<div class="sidebar-widget mb-50">
		<h3 class="sidebar-title">Search Products</h3>
		<div class="sidebar-search">
			<form action="#">
				<input class="form-control" placeholder="Cari produk di toko ini . . ." type="text" name="cari" value="{{$cari}}">
				<button><i class="ti-search"></i></button>
			</form>
		</div>
	</div>

	@if ($category)
	<div class="sidebar-widget mb-45">
		<h3 class="sidebar-title">Categories</h3>
		<div class="sidebar-categories">
			<ul>
				@foreach ($category as $cat)
				@if(!Auth::user())
				<li><a href="{{ url('stores')}}/{{($prod->store_id.'?category='. $cat->id_category) }}">{{ $cat->name }}</a></li>
				@endif
				@if(Auth::user())
				<li><a href="{{ url('/home/stores')}}/{{($prod->store_id.'?category='. $cat->id_category) }}">{{ $cat->name }}</a></li>
				@endif
				@endforeach
			</ul>
		</div>
	</div>
	@endif
</div>