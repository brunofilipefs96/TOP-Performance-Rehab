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
        return $this->belongsToMany(Product::class, 'product_sale')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function packs()
    {
        return $this->belongsToMany(Pack::class, 'pack_sale')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
