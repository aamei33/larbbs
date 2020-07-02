<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Auth;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    //
    public function __construct(){
        //未登录用户 只可以访问show
        // 如果访问到 则跳转到登录页面
        $this->middleware('auth',['except'=>['show']]);
    }

    public function show(User $user){
        return view('users.show', compact('user'));

    }

    public function edit(User $user){
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();


        // 第一种方法
        //$file = $request->file('avatar');

        // 第二种方法，可读性更高
        $file = $request->avatar;


        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];

            }
        }


        $user->update($data);

        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');



    }
}
