<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripeLogs extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', // Review for this user
        'request',
        'response',
        'ip',
        'agent',
    ];

    protected $casts = [
        'request'=>'array',
        'response'=>'array',
    ];

    public static function create($type="",$req="",$resp=""){
        $elq = new StripeLogs();
        $elq->fill([
            'type'=>$type,
            'request'=>$req,
            'response'=>$resp,
        ])->save();
    }
}
