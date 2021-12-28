<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    const NUMBER_PREFIX = 'MK';
    const NUMBER_SEPARATOR = '/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'transaction_id',
        'invoice_number',
        'qty',
        'attachment',
        'status',
    ];

    public function getNumber()
    {
        return self::NUMBER_PREFIX.self::NUMBER_SEPARATOR.$this->id.self::NUMBER_SEPARATOR.date('Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
