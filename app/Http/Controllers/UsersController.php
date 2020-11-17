<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

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
    public function update(UserRequest $request, User $user){
        $user->update($request->all());
        return redirect()->route('users.show',$user->id)->with('success','个人信息更新成功！');
    }

}
