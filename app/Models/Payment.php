<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'charge_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'receipt_url',
        'postal_code',
    ];
}
