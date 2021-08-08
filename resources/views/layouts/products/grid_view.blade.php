<div class="row">
    @forelse ($products as $product)
    @include('layouts.products.grid_box')
    @empty
    No product found!
    @endforelse
</div>