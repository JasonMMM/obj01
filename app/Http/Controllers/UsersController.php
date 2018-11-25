<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function __construct()
    {
        //只允许已登录用户访问的页面
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index'],
        ]);
        //只允许未登录用户访问的页面
        $this->middleware('guest', [
            'only'  =>  ['create'],
        ]);
    }

    public function index()
    {
        $userList = User::paginate(10);
        return view('users.index', compact('userList'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * 显示用户详情
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        $this->authorize('update', $user);
        return view('users.show', compact('user'));
    }

    /**
     * 新用户注册
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|min:4|confirmed'
        ]);

        //获取提交的表单数据，并存入数据库中，并使用session作为缓存，跳转后提示用户登录成功
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        if (!$user) {
            session()->flash('danger', '用户创建失败，请重试');
            return redirect()->route('user.create');
        }
        //用户注册成功后，自动登录
        Auth::login($user);
        //使用session方法，来访问laravel封装好的会话实例。
        //当我们想存入一条缓存数据，让它只在下一次的请求内有效时，可以使用flash()方法。第一个参数是会话的键，第二个值是会话的值
        session()->flash("success", "Hello，" . $user->name . "，欢迎来到你的世界。");
        return redirect()->route('users.show', [$user]);
    }

    /**
     * 编辑用户
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user); 
        return view('users.edit', compact('user'));
    }

    /**
     * 更新用户
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:4'
        ]);
        
        $this->authorize('update', $user);
        $data = [
            'name' => $request->name,
        ];
        //如果密码为空，表示不更新密码
        if ($request->password) {
            $data = [
                'password' => bcrypt($request->password)
            ];
        }
        $user->update($data);
        session()->flash('success', '资料更新成功');
        return redirect()->route('users.show', $user->id);
    }

    /**
     * 删除用户
     *
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '删除成功');
        return back();
    }
}
