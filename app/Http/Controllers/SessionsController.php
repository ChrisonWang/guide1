<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('session.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();
            session()->flash('success', '亲爱的 '.$user->name.'，欢迎回来！');
            return redirect()->route('users.show', [$user]);
        } else {
            session()->flash('danger', '对不起，登录邮箱或密码错误');
            return redirect()->back();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出登录！');
        return redirect('login');
    }
}
