<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
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
     * 用户登录页面
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

        /**
         * 
         * 判断前端表单传递过来的remember是否有值
         * @method $request->has('remember');
         * 
         */
        //匹配数据库
        if(Auth::attempt($credentials, $request->has('remember'))){
            session()->flash("success", "Hello，" . Auth::user()->name . "，欢迎来到你的世界。");
            return redirect()->route('users.show', [Auth::user()]);
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
