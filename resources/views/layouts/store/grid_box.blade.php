<div class="col-md-6 col-xl-4">
	<div class="product-wrapper mb-30">
		<div class="product-img">
			@if(!Auth::user())
			<a href="{{ url('product/'. $product->slug.'/'.$product->id_product) }}">
				@if ($product->galleries->first())
				<img src="{{ asset('storage/images/product/'.$product->galleries->first()->photo) }}" style="width:250px; height:350px; object-fit:contain;" alt="{{ $product->nama_product }}">
				@else
				<img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $product->nama_product }}">
				@endif
			</a>
			@endif
			@if(Auth::user())
			<a href="{{ url('home/product/'. $product->slug.'/'.$product->id_product) }}">
				@if ($product->galleries->first())
				<img src="{{ asset('storage/images/product/'.$product->galleries->first()->photo) }}" style="width:250px; height:350px; object-fit:contain;" alt="{{ $product->nama_product }}">
				@else
				<img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $product->nama_product }}">
				@endif
			</a>
			@endif
			@if($product->stock_product == 0)
			<span>Habis</span>
			@endif
			<!-- <div class="product-action">
				@if(Auth::user())
				<a class="animate-top" title="Add To Cart" href="">
					<i class="pe-7s-cart"></i>
				</a>
				@endif
				<a class="animate-right" title="Quick View" data-toggle="modal" href="#detail-{{$product->id_product}}">
					<i class="pe-7s-look"></i>
				</a>
			</div> -->
		</div>
		<div class="product-content">
			<p class="ml-auto" style="float:right;">{{$product->store->city->name }}</p>
			<h4><a class="d-inline-block" href="{{ url('product/'. $product->slug.'/'.$product->id_product)}}">{{ $product->nama_product }}</a></h4>
			<span>Rp. {{ number_format($product->harga_product) }}</span>
		</div>
	</div>
</div>