<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'crypto', 'purchase_value', 'purchase_quantity'
    ];

    protected $hidden = [
        'sold'
    ];
}
