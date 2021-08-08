<!-- product area start -->
<div class="popular-product-area wrapper-padding-3 pt-50 pb-150">
    <div class="container-fluid">
        <div class="section-title-3 text-center mb-50">
            <h2>Popular Product In This Month</h2>
        </div>
        <div class="product-style">
            <div class="popular-product-active owl-carousel">
                @foreach($populer as $pop)
                <div class="product-wrapper">
                    <div class="product-img">
                        @if(!Auth::user())
                        <a href="{{ url('product/'. $pop->slug.'/'.$pop->id_product) }}">
                            @if ($pop->galleries->first())
                            <img src="{{ asset('storage/images/product/'.$pop->galleries->first()->photo) }}" style="width:250px; height:350px; object-fit:contain;" alt="{{ $pop->nama_product }}">
                            @else
                            <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $pop->nama_product }}">
                            @endif
                        </a>
                        @endif
                        @if(Auth::user())
                        <a href="{{ url('home/product/'. $pop->slug.'/'.$pop->id_popuct) }}">
                            @if ($pop->galleries->first())
                            <img src="{{ asset('storage/images/product/'.$pop->galleries->first()->photo) }}" style="width:250px; height:350px; object-fit:contain;" alt="{{ $pop->nama_product }}">
                            @else
                            <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $pop->nama_product }}">
                            @endif
                        </a>
                        @endif
                        @if($pop->stock_product == 0)
                        <span>Habis</span>
                        @endif
                    </div>
                    <div class="funiture-product-content text-center">
                        <h4><a href="">{{$pop->nama_product}}</a></h4>
                        <p>{{$pop->store->city->name}}</p>
                        <span>Rp. {{number_format($pop->harga_product)}}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- product area end -->