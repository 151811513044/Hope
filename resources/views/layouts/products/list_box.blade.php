<div class="col-lg-12">
    <div class="product-wrapper mb-30 single-product-list product-list-right-pr mb-60">
        <div class="product-img list-img-width">
            @if(!Auth::user())
            <a href="{{ url('/product/'. $product->slug.'/'.$product->id_product) }}">
                @if ($product->galleries->first())
                <img src="{{ asset('storage/images/product/'.$product->galleries->first()->photo) }}" alt="{{ $product->nama_product }}">
                @else
                <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/1.jpg') }}" alt="{{ $product->name }}">
                @endif
            </a>
            @endif
            @if(Auth::user())
            <a href="{{ url('/home/product/'. $product->slug.'/'.$product->id_product) }}">
                @if ($product->galleries->first())
                <img src="{{ asset('storage/images/product/'.$product->galleries->first()->photo) }}" alt="{{ $product->nama_product }}">
                @else
                <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/1.jpg') }}" alt="{{ $product->name }}">
                @endif
            </a>
            @endif
            @if($product->stock_product == 0)
            <span>Habis</span>
            @endif
            <!-- <div class="product-action-list-style">
                @if(Auth::user())
                <a class="animate-top" title="Add To Cart" href="">
                    <i class="pe-7s-cart"></i>
                </a>
                @endif
            </div> -->
        </div>
        <div class="product-content-list">
            <div class="product-list-info">
                <h4><a href="{{ url('product/'. $product->slug. '/'. $product->id_product) }}">{{ $product->nama_product }}</a></h4>
                @if(!Auth::user())
                <span>Toko : <a href="{{url('/stores')}}/{{$product->store_id}}" class="text-success">{{$product->store->name}}</a></span>
                @endif
                @if(Auth::user())
                <span>Toko : <a href="{{url('/home/stores')}}/{{$product->store_id}}" class="text-success">{{$product->store->name}}</a></span>
                @endif
                <p>{{$product->store->city->name}}</p>
                <span>Rp. {{ number_format($product->harga_product) }}</span>
                <p>{!! $product->description !!}</p>
            </div>
            <div class="product-list-cart-wishlist">
                <div class="product-list-cart">
                    <a class="btn-hover list-btn-style" href="#">add to cart</a>
                </div>
            </div>
        </div>
    </div>
</div>