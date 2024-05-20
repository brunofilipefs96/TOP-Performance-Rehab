@extends('master.main')
@section('content')
    @component('components.product.product-form-show', ['product' => $product])
    @endcomponent
@endsection
