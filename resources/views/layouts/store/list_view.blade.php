<div class="row">
	@forelse ($products as $product)
	@include('layouts.store.list_box')
	@empty
	No product found!
	@endforelse
</div>