<x-app-layout>

    @component('components.sales.sale-form-show',
        [
            'sale' => $sale,
            'paymentStatus' => $paymentStatus,
            'paymentReference' => $paymentReference,
            'paymentEntity' => $paymentEntity,
            'amount' => $amount,
            'paymentVoucherUrl' => $paymentVoucherUrl,
            'receiptUrl' => $receiptUrl,
            'validity' => $validity,
        ])
    @endcomponent

</x-app-layout>
