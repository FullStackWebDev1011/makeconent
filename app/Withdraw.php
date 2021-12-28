<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'bill_id',
        'qty',
        'fee',
        'type',
        'status',
        'finish_date',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'finish_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
