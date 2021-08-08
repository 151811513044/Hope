<div class="shop-sidebar mr-50">
    <!-- <form method="GET" action="{{ url('products')}}">
        <div class="sidebar-widget mb-40">
            <h3 class="sidebar-title">Filter by Price</h3>
            <div class="price_filter">
                <div id="slider-range"></div>
                <div class="price_slider_amount">
                    <div class="label-input">
                        <label>price : </label>
                        <input type="text" id="amount" name="price" placeholder="Add Your Price" style="width:170px" />
                        <input type="hidden" id="productMinPrice"  />
                        <input type="hidden" id="productMaxPrice"  />
                    </div>
                    <button type="submit">Filter</button>
                </div>
            </div>
        </div>
    </form> -->
    @if($category)
    <div class="sidebar-widget mb-45">
        <h3 class="sidebar-title">Categories</h3>
        <div class="sidebar-categories">
            @foreach($category as $cat)
            <ul>
                @if(!Auth::user())
                <li><a href="{{url('/products?category='. $cat->id_category)}}">{{$cat->name}}</a></li>
                @endif
                @if(Auth::user())
                <li><a href="{{url('/home/products?category='. $cat->id_category)}}">{{$cat->name}}</a></li>
                @endif
            </ul>
            @endforeach
        </div>
    </div>
    @endif
</div>