<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'item',
        'item_id',
        'qty',
        'category_id',
        'price',
        'total',
    ];
}
