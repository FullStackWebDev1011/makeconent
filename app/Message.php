<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //

    public function send_user() {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function receive_user() {
        return $this->hasOne('App\User', 'id', 'receiver_id');
    }
}
