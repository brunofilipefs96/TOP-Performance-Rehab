<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'address_id',
        'status_id',
        'nif',
        'total',
        'payment_method'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'price', 'quantity_shortage');
    }

    public function packs()
    {
        return $this->belongsToMany(Pack::class)
            ->withPivot('quantity', 'price');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function getTranslatedStatusAttribute()
    {
        $translations = [
            'pending_payment' => 'A aguardar pagamento',
            'paid' => 'Pago',
            'canceled' => 'Cancelado',
            'delivered' => 'Entregue',
            'returned' => 'Devolvido',
            'refunded' => 'Reembolsado',
            'awaiting_pickup' => 'A aguardar levantamento',
        ];

        return $translations[$this->status->name] ?? 'Desconhecido';
    }
}
