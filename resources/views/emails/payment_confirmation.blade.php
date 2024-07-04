<!DOCTYPE html>
<html>
<head>
    <title>Payment Confirmation</title>
</head>
<body>
<h1>Payment Confirmation</h1>
<p>Dear {{ $sale->user->name }},</p>
<p>Your payment has been successfully processed. Thank you for your purchase!</p>
<p>Order Details:</p>
<ul>
    @foreach ($sale->products as $product)
        <li>{{ $product->name }} - Quantity: {{ $product->pivot->quantity }}</li>
    @endforeach
    @foreach ($sale->packs as $pack)
        <li>{{ $pack->name }} - Quantity: {{ $pack->pivot->quantity }}</li>
    @endforeach
</ul>
<p>Total: €{{ number_format($sale->total, 2) }}</p>
</body>
</html>
