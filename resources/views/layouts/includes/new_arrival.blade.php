<!-- New Arrival -->
<div class="top-month pb-120">
    <div class="container">
        <div class="section-title-3 text-center mb-70">
            <h2>New Arrival</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="writer-wrapper">
                    @if(!Auth::user())
                    <a href="{{ url('product/'. $arrival->first()->slug.'/'.$arrival->first()->id_product) }}">
                        @if ($arrival->first()->galleries->first())
                        <img src="{{ asset('storage/images/product/'.$arrival->first()->galleries->first()->photo) }}" style="width:370px; height:530px; object-fit:fill;" alt="{{ $arrival->first()->nama_product }}">
                        @else
                        <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $arrival->first()->nama_product }}">
                        @endif
                    </a>
                    @endif
                    @if(Auth::user())
                    <a href="{{ url('home/product/'. $arrival->first()->slug.'/'.$arrival->first()->id_product) }}">
                        @if ($arrival->first()->galleries->first())
                        <img src="{{ asset('storage/images/product/'.$arrival->first()->galleries->first()->photo) }}" style="width:370px; height:530px; object-fit:fill;" alt="{{ $arrival->first()->nama_product }}">
                        @else
                        <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $arrival->first()->nama_product }}">
                        @endif
                    </a>
                    @endif
                    <div class="writer-content">
                        <h4>{{$arrival->first()->nama_product}}</h4>
                        <p>{{$arrival->first()->store->city->name}}</p>
                        <span>Rp. {{number_format($arrival->first()->harga_product)}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="book-list-hover">
                    <div class="book-list-active owl-carousel">
                        @foreach($arrival as $key=>$arv)
                        @if($key > 0)
                        <div class="product-wrapper">
                            <div class="product-img">
                                @if(!Auth::user())
                                <a href="{{ url('product/'. $arv->slug.'/'.$arv->id_product) }}">
                                    @if ($arv->galleries->first())
                                    <img src="{{ asset('storage/images/product/'.$arv->galleries->first()->photo) }}" style="width:325px; height:350px; object-fit:fill;" alt="{{ $arv->nama_product }}">
                                    @else
                                    <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $arv->nama_product }}">
                                    @endif
                                </a>
                                @endif
                                @if(Auth::user())
                                <a href="{{ url('home/product/'. $arv->slug.'/'.$arv->id_product) }}">
                                    @if ($arv->galleries->first())
                                    <img src="{{ asset('storage/images/product/'.$arv->galleries->first()->photo) }}" style="width:325px; height:350px; object-fit:fill;" alt="{{ $arv->nama_product }}">
                                    @else
                                    <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $arv->nama_product }}">
                                    @endif
                                </a>
                                @endif
                            </div>
                            <div class="product-content-3 text-center">
                                <h4>{{$arv->nama_product}}</h4>
                                <p>{{$arv->store->city->name}}</p>
                                <span>Rp. {{number_format($arv->harga_product)}}</span>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End New Arrival -->