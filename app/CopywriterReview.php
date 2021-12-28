<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CopywriterReview extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', // Review for this user
        'project_id',
        'from_user_id',
        'rate',
        'comment',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
}
