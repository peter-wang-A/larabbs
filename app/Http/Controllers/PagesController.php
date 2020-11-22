<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function root()
    {
        return view('pages.root');
    }


    //注册验证
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'captcha' => ['required', 'captcha'],
        ], [
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '请输入正确的验证码',
        ]);
    }


    public function permissionDenied()
    {
        //如果当前用户有权限访问后台，直接跳转访问
        /**
         * permission() 是一个方法需要执行才能返回结果
         */
        if (config('administrator.permission')()) {
            return redirect(config('administrator.uri'), 302);
        }
        //否则使用视图
        return view('pages.permission_denied');
    }
}
