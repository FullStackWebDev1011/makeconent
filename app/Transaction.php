<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const STATUS_SUCCESS = 'success';
    const STATUS_CANCEL = 'cancel';
    const STATUS_FINISH = 'finish';
    const STATUS_PENDING = 'pending';

    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPE_ORDER = 'order';
    const TYPE_BUY = 'buy';
    const TYPE_SELL = 'sell';
    const TYPE_REFUND = 'refund';
    const TYPE_FEE = 'fee';
    const TYPE_BONUS = 'bonus';


    protected $fillable = [
        'user_id',
        'status',
        'type',
        'qty',
        'source',
        'currency',
    ];

    public function getPublicId()
    {
        return '#'.str_pad($this->id, 6, STR_PAD_LEFT, '0');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
