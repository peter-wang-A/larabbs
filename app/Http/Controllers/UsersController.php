<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    //个人中心展示页面
    public function show(User $user){
        return view('users.show',compact('user'));
    }

    //修改资料页面
    public function edit(User $user){
        return view('users.edit',compact('user'));
    }

    //修改数据提交
    public function update(Request $request, User $user){
        //
    }


}
