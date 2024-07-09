<!DOCTYPE html>
<html>
<head>
    <title>Referência de Pagamento Multibanco</title>
</head>
<body>
<h1>Referência de Pagamento Multibanco</h1>
<p>Olá {{ $sale->user->firstLastName() }},</p>
<p>Utilize as seguintes informações para completar o seu pagamento:</p>
<ul>
    <li><strong>Entidade:</strong> {{ $paymentEntity }}</li>
    <li><strong>Referência:</strong> {{ $paymentReference }}</li>
    <li><strong>Montante:</strong> {{ number_format($amount, 2) }} €</li>
</ul>
<p>Obrigado pela sua compra!</p>
</body>
</html>
