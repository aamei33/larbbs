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
    public function show(User $user){
        return view('users.show', compact('user'));

    }

    public function edit(User $user){
        return view('users.edit',compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();


        // 第一种方法
        //$file = $request->file('avatar');

        // 第二种方法，可读性更高
        $file = $request->avatar;


        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id);
            if ($result) {
                $data['avatar'] = $result['path'];

            }
        }


        $user->update($data);

        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');



    }
}
