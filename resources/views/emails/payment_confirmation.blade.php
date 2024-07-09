<!DOCTYPE html>
<html>
<head>
    <title>Confirmação de Pagamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .header h1 {
            margin: 0;
            color: #4CAF50;
        }
        .content {
            padding: 20px 0;
        }
        .content p {
            margin: 10px 0;
        }
        .order-details {
            list-style: none;
            padding: 0;
        }
        .order-details li {
            margin: 5px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }
        .receipt {
            background-color: #e9f7ef;
            border: 1px solid #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #999;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            font-size: 16px;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Confirmação de Pagamento</h1>
    </div>
    <div class="content">
        <p>Caro(a) {{ $sale->user->name }},</p>
        <p>O seu pagamento foi processado com sucesso. Obrigado pela sua compra!</p>
        @if(!$isEnrollmentFee)
            <p>Detalhes da Encomenda:</p>
            <ul class="order-details">
                @foreach ($sale->products as $product)
                    <li>{{ $product->name }} - Quantidade: {{ $product->pivot->quantity }}</li>
                @endforeach
                @foreach ($sale->packs as $pack)
                    <li>{{ $pack->name }} - Quantidade: {{ $pack->pivot->quantity }}</li>
                @endforeach
            </ul>
        @endif
        <p><strong>Total: €{{ number_format($sale->total, 2) }}</strong></p>
        @if(isset($receiptUrl) && $receiptUrl)
            <div class="receipt">
                <p>O seu recibo de pagamento está disponível no link abaixo:</p>
                <a href="{{ $receiptUrl }}" class="btn" target="_blank">Ver Recibo</a>
            </div>
        @endif
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Sua Empresa. Todos os direitos reservados.</p>
    </div>
</div>
</body>
</html>