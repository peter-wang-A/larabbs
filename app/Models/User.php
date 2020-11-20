<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        //如果要通知的人是当前用户就不用通知了
        if ($this->id == Auth::id()) {
            return;
        }

        //只有数据库类型通知才需要提醒，直接发 Email 或者 ...
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //一个作者有多个话题
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }


    //一个作者有多条评论
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    //权限验证封装方法
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    //清除通知
    public function markAsRead(){
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
