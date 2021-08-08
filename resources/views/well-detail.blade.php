@extends('template')

@section('content')

<div class="product-details ptb-100 pb-90">
    <div class="container">
        <div class="row p-4">
            <div class="col-md-12 col-lg-7 col-12">
                <div class="product-details-img-content">
                    <div class="product-details-tab mr-70">
                        <div class="product-details-large tab-content">
                            @php
                            $i = 1
                            @endphp
                            @forelse ($products->galleries as $image)
                            <div class="tab-pane fade {{ ($i == 1) ? 'active show' : '' }}" id="pro-details{{ $i}}" role="tabpanel">
                                <img src="{{ asset('storage/images/product/'.$image->photo) }}" style="width:600px; height:656px; object-fit:contain;" alt="{{ $products->nama_product }}">
                            </div>
                            @php
                            $i++
                            @endphp
                            @empty
                            No image found!
                            @endforelse
                        </div>
                        <div class="product-details-small nav mt-12" role=tablist>
                            @php
                            $i = 1
                            @endphp
                            @forelse ($products->galleries as $image)
                            <a class="{{ ($i == 1) ? 'active' : '' }} mr-12 mb-1" href="#pro-details{{ $i }}" data-toggle="tab" role="tab" aria-selected="true">
                                <img src="{{ asset('storage/images/product/'. $image->photo) }}" style="width:141px; height:135px; object-fit:cover;" alt="{{$products->nama_product}}">
                            </a>
                            @php
                            $i++
                            @endphp
                            @empty
                            No image found!
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5 col-12">
                <div class="product-details-content">
                    <h3>{{ $products->nama_product}}</h3>
                    <div class="price">
                        @if(!Auth::user())
                        <span>Toko : <a href="{{url('/stores')}}/{{$products->id_product}}" class="text-success">{{$products->store->name}}</a></span>
                        @endif
                        @if(Auth::user())
                        <span>Toko : <a href="{{url('/home/stores')}}/{{$products->id_product}}" class="text-success">{{$products->store->name}}</a></span>
                        @endif
                    </div>
                    <p>{{$products->store->city->name}}</p>
                    <div class="rating-number">
                        <div class="quick-view-rating">
                            <i class="pe-7s-star red-star"></i>
                            <i class="pe-7s-star red-star"></i>
                            <i class="pe-7s-star"></i>
                            <i class="pe-7s-star"></i>
                            <i class="pe-7s-star"></i>
                        </div>
                        <div class="quick-view-number">
                            <span>2 Ratting (S)</span>
                        </div>
                    </div>
                    <div class="details-price">
                        <span>{{ number_format($products->harga_product) }}</span>
                    </div>
                    <span>Stock : <strong>{{$products->stock_product}}</strong></span>
                    <form action="{{url('/cart')}}/{{$products->id_product}}" method="post">
                        @csrf
                        <div class="quickview-plus-minus">
                            <div class="cart-plus-minus">
                                <input type="text" class="cart-plus-minus-box" name="qty" placeholder="qty" value="1">
                            </div>
                            <div class="quickview-btn-cart">
                                <button type="submit" class="submit contact-btn btn-hover">add to cart</button>
                            </div>
                        </div>
                    </form>
                    <div class="product-details-cati-tag mt-35">
                        <ul>
                            <li class="categories-title">Categories :</li>
                            <li><span>{{ $products->category->name }}</span></li>
                        </ul>
                    </div>
                    <div class="product-details-cati-tag mtb-10">
                        <ul>
                            <!-- <li class="categories-title">Seller :</li>
                            <li><a href="">{{ $products->store->name }}</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-description-review-area pb-90">
    <div class="container">
        <div class="product-description-review text-center">
            <div class="description-review-title nav" role=tablist>
                <a class="active" href="#pro-dec" data-toggle="tab" role="tab" aria-selected="true">
                    Description
                </a>
                <a href="#pro-review" data-toggle="tab" role="tab" aria-selected="false">
                    Reviews ({{$notif}})
                </a>
            </div>
            <div class="description-review-text tab-content">
                <div class="tab-pane active show fade" id="pro-dec" role="tabpanel">
                    <p>{!! $products->long_description !!}</p>
                </div>
                <div class="tab-pane fade" id="pro-review" role="tabpanel">
                    @if($reviews)
                    <div class="container-fluid">
                        <div class="row mb-5">
                            @foreach($reviews as $review)
                            <div class="col-md-6 mb-2">
                                <div class="card text-left">
                                    <div class="card-header">
                                        {{$review->customer->name}} ({{$review->customer->users->name}})
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <ul>
                                                <li class="col-9 d-inline text-justify">{{$review->comment}}</li>
                                                @if($review->photo != null)
                                                <li class="col-3 text-right"><img src="{{asset('/images/admin.jpg')}}" alt=""></li>
                                                @endif
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{$reviews->links()}}
                    </div>
                    @else
                    <h4>Belum Terdapat Review atau Komentar</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product area start -->
<div class="popular-product-area wrapper-padding-3 pt-50 pb-50">
    <div class="container-fluid">
        <div class="section-title-6 text-center mb-50">
            <h2>- Related Product -</h2>
        </div>
        <div class="product-style">
            <div class="popular-product-active owl-carousel">
                @foreach($product as $prod)
                @if($prod->id_product != $products->id_product)
                <div class="product-wrapper">
                    <div class="product-img">
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
                    </div>
                    <div class="funiture-product-content text-center">
                        <h4><a href="">{{$prod->nama_product}}</a></h4>
                        <p>{{$prod->store->city->name}}</p>
                        <span>Rp. {{number_format($prod->harga_product)}}</span>
                    </div>
                </div>
                @else
                No Data Product Available
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- product area end -->
@endsection