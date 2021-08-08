<!-- product area start -->
<div class="popular-product-area wrapper-padding-3 pb-50">
    <div class="container-fluid">
        <div class="section-title-3 text-center mb-50">
            <h2>More Product</h2>
        </div>
        <div class="custom-row">
            @foreach($products as $prod)
            <div class="custom-col-5  mb-95">
                @php
                $i= 1
                @endphp
                <div class="product-wrapper {{$i}}">
                    <div class="product-img text-center">
                        @if(!Auth::user())
                        <a href="{{ url('product/'. $prod->slug.'/'.$prod->id_product) }}">
                            @if ($prod->galleries->first())
                            <img src="{{ asset('storage/images/product/'.$prod->galleries->first()->photo) }}" style="width:250px; height:350px; object-fit:contain;" alt="{{ $prod->nama_product }}">
                            @else
                            <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $prod->nama_product }}">
                            @endif
                        </a>
                        @endif
                        @if(Auth::user())
                        <a href="{{ url('home/product/'. $prod->slug.'/'.$prod->id_product) }}">
                            @if ($prod->galleries->first())
                            <img src="{{ asset('storage/images/product/'.$prod->galleries->first()->photo) }}" style="width:250px; height:350px; object-fit:contain;" alt="{{ $prod->nama_product }}">
                            @else
                            <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $prod->nama_product }}">
                            @endif
                        </a>
                        @endif
                        @if($prod->stock_product == 0)
                        <span>Habis</span>
                        @endif
                    </div>
                    <div class="product-content-2 text-center">
                        <h4>{{$prod->nama_product}}</h4>
                        <p>{{$prod->store->city->name}}</p>
                        <span>Rp. {{number_format($prod->harga_product)}}</span>
                    </div>
                </div>
                @php
                $i++
                @endphp
            </div>
            @endforeach
        </div>
        <div class="view-all-product text-center">
            @if(Auth::user())
            <a href="{{route('product')}}">View All Product</a>
            @endif
            @if(!Auth::user())
            <a href="{{ url('/products') }}">View All Product</a>
            @endif
        </div>
    </div>
</div>
<!-- product area end -->