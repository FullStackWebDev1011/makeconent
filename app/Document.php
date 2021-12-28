<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    const NUMBER_PREFIX = 'DC';
    const NUMBER_SEPARATOR = '/';

    const STATUS_CANCEL = 'cancel';
    const STATUS_PENDING = 'pending';
    const STATUS_FINISH = 'finish';

    public function getNumber()
    {
        return self::NUMBER_PREFIX.self::NUMBER_SEPARATOR.$this->id.self::NUMBER_SEPARATOR.date('Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
