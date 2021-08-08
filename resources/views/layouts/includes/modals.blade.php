<!-- modal detail-->
@foreach($products as $product)
<div class="modal fade" id="detail-{{$product->id_product}}" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span class="pe-7s-close" aria-hidden="true"></span>
    </button>
    <div class="modal-dialog modal-quickview-width" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="qwick-view-left">
                    <div class="quick-view-learg-img">
                        <div class="quick-view-tab-content tab-content">
                            @php
                            $i = 1
                            @endphp
                            @forelse ($product->galleries as $image)
                            <div class="tab-pane fade {{ ($i == 1) ? 'active show' : '' }}" id="pro-details{{ $i}}" role="tabpanel">
                                <img src="{{ asset('images/product/'.$image->photo) }}" style="width:320px; height:380px; object-fit:contain;" alt="{{ $product->nama_product }}">
                            </div>
                            @php
                            $i++
                            @endphp
                            @empty
                            No image found!
                            @endforelse
                        </div>
                    </div>
                    <div class="quick-view-list nav" role="tablist">
                        @php
                        $i = 1
                        @endphp
                        @forelse ($product->galleries as $image)
                        <a class="{{ ($i == 1) ? 'active' : '' }} mr-12 mb-1" href="#pro-details{{ $i }}" data-toggle="tab" role="tab" aria-selected="true">
                            <img src="{{ asset('images/product/'.$image->photo) }}" style="width:141px; height:135px; object-fit:cover;" alt="">
                        </a>
                        @php
                        $i++
                        @endphp
                        @empty
                        No image found!
                        @endforelse
                    </div>
                </div>
                <div class="qwick-view-right">
                    <div class="qwick-view-content">
                        <h3>{{$product->nama_product}}</h3>
                        <div class="price">
                            @if(!Auth::user())
                            <span>Toko : <a href="{{url('/stores')}}/{{$product->id_product}}" class="text-success">{{$product->store->name}}</a></span>
                            @endif
                            @if(Auth::user())
                            <span>Toko : <a href="{{url('/home/stores')}}/{{$product->id_product}}" class="text-success">{{$product->store->name}}</a></span>
                            @endif
                        </div>
                        <p>{{$product->store->city->name}}</p>
                        <div class="price">
                            <span class="new">{{number_format($product->harga_product)}}</span>
                        </div>
                        <div class="rating-number">
                            <div class="quick-view-rating">
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                            </div>
                            <div class="quick-view-number">
                                <span>2 Ratting (S)</span>
                            </div>
                        </div>
                        <p>{!!$product->description!!}</p>
                        <!-- <div class="quick-view-select">
                            <div class="select-option-part">
                                <label>Size*</label>
                                <select class="select">
                                    <option value="">- Please Select -</option>
                                    <option value="">900</option>
                                    <option value="">700</option>
                                </select>
                            </div>
                            <div class="select-option-part">
                                <label>Color*</label>
                                <select class="select">
                                    <option value="">- Please Select -</option>
                                    <option value="">orange</option>
                                    <option value="">pink</option>
                                    <option value="">yellow</option>
                                </select>
                            </div>
                        </div> -->
                        <form action="" method="post">
                            <div class="quickview-plus-minus">
                                <div class="cart-plus-minus">
                                    <input type="text" class="cart-plus-minus-box" name="qty" readonly placeholder="qty" value="1">
                                </div>
                                <div class="quickview-btn-cart">
                                    <button type="submit" class="submit contact-btn btn-sm btn-hover">add to cart</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<!--end modal -->