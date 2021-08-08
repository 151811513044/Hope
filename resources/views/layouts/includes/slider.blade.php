<div class="slider-area">
    <div class="container-fluid">
        <div class="row p-4">
            <div class="col-md-2">
                <div class="sidebar-widget">
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
            </div>
            <div class="col-md-10">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" style="background-color:cadetblue;">
                        @foreach($carousels as $key => $carousel)
                        <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                            <img src="{{asset('storage/images/carousel/'.$carousel->photo.'')}}" style="width:1180px; height:400px; object-fit:corner;" alt="...">
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
</div>