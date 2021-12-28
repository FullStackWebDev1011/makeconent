<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    const STATUS_OPEN = 'open';
    const STATUS_PENDING = 'pending';
    const STATUS_FINISH = 'finish';
    const STATUS_CANCEL = 'cancel';

    public $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }
}
