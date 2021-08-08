@extends('layouts.app')

@section('content')
@include('layouts.includes.slider')
@include('layouts.includes.popular_products')
@include('layouts.includes.new_arrival')
@include('layouts.includes.products')
@include('layouts.includes.modals')

@endsection

@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@include('sweet::alert')
@endsection