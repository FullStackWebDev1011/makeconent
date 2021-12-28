<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'source',
        'total_balance',
        'credit_balance',
        'bonus_code',
        'bonus',
    ];
}
