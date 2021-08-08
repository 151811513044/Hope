<div class="row">
	@forelse ($products as $product)
	@include('layouts.products.list_box')
	@empty
	No product found!
	@endforelse
</div>