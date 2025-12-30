<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'customer_name',
        'total',
        'tax',
        'discount',
        'grand_total',
        'status',
        'sale_date',
        'notes',
        'product_id', // keeping these for backward compatibility/legacy sales if any
        'product_name',
        'quantity',
        'price',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
