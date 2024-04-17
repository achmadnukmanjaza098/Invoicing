<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'date',
        'due_date',
        'subtotal',
        'tax',
        'total',
        'status_payment',
        'payment_method',
        'proof_of_payment',
        'brand_id',
    ];
}
