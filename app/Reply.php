<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded=[];

    public function comment()
    {
        return $this->belongsTo(Comment::class,'reply_to_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'reply_user_id');
    }
}
