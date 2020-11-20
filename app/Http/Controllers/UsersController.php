<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Topic;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;


class UsersController extends Controller
{
    //权限验证
    public function __construct()
    {
        $this->middleware('auth', ['excepy' => ['show']]);
    }
    //个人中心展示页面
    public function show(User $user, Topic $topic, Request $request)
    {
        $topics = Topic::where('user_id', $user->id)->paginate(30);
        return view('users.show', compact(['user', 'topics']));
    }

    //修改资料页面
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    //修改数据提交
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatar', $user->id, 208);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user)->with('success', '个人信息更新成功！');
    }
}
