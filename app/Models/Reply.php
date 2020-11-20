<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['content'];

    //一条评论只对一个话题
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    //一条评论只对一个用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
