@extends('master.main')

@section('content')

    @component('components.product.product-form-create', ['products' => $products])
    @endcomponent

@endsection


