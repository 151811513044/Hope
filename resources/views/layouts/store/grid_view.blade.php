<div class="row">
    @forelse ($products as $product)
    @include('layouts.store.grid_box')
    @empty
    No product found!
    @endforelse
</div>