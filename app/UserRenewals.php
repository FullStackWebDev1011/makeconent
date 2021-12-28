<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRenewals extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', // Review for this user
        'email',
        'amount',
        'status',
    ];

    public function user(){
        return $this->hasOne(new User(), "email", "email");
    }
}
