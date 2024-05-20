@extends('master.main')

@section('content')

    @component('components.product.product-list', ['products' => $products])
    @endcomponent

@endsection
