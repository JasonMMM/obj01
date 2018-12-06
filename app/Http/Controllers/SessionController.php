<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{

    public function __construct()
    {
        //只允许未登录用户访问的页面
        $this->middleware('guest', [
            'only'  =>  ['create']
        ]);
    }

    /**
     * 登录页面
     *
     * @return void
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * 用户登录信息校验
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //校验表单参数
        //@param $credentials array 返回值为表单的数据
        $credentials = $this->validate($request, [
            'email'     =>  'required|email|max:255',
            'password'  =>  'required'
        ]);
         // 判断前端表单传递过来的remember是否有值
         //@method $request->has('remember');
        //匹配数据库
        if(Auth::attempt($credentials, $request->has('remember'))){
            $user = Auth::user();
            //判断邮箱是否已激活
            if($user->activated) {
                session()->flash("success", "Hello，" . $user->name . "，欢迎来到你的世界。");
                return redirect()->intended(route('users.show', compact('user')));
            }else{
                //如果没有激活邮箱，退出当前的登录状态
                Auth::logout();
                session()->flash('warning', '账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
            
        }else{
            session()->flash('danger', '少侠，通关文牒信息有误，请重新来过~');
            return redirect()->back();
        }
    }

    /**
     * 用户退出登录
     *
     * @return void
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出');
        return redirect('/');
    }
}
