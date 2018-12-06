<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'  =>  'check'], function(){
    //首页
    Route::any('/', 'StaticPagesController@home')->name('home');
    //帮助页
    //为路由定义名称
    Route::any('/help', 'StaticPagesController@help')->name('help');
    //关于页
    Route::any('/about', 'StaticPagesController@about')->name('about');
    //注册页
    Route::any('/signup', 'UsersController@create')->name('signup');

    //使用resource定义user路由
    Route::resource('/users', 'UsersController');

    //会话路由
        //用户登录页面
    Route::get('/login', 'SessionController@create')->name('login');
        //用户信息校验
    Route::post('/login', 'SessionController@store')->name('login');
        //用户登出(销毁用户会话)
    Route::delete('/logout', 'SessionController@destroy')->name('logout');

    //邮件发送
    Route::get('/signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

    //密码重置
    Route::group(['prefix'  =>  'auth', 'namespace' =>  'Auth'], function () {
        //显示重置密码的路由
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        //发送重置密码邮件的路由
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        //从邮箱中跳转至重置密码页面的路由
        Route::get('/password/reset/{token}/{email}', 'ResetPasswordController@showResetForm')->name('password.reset');
        //提交密码重置信息
        Route::post('/pawword/reset', 'ResetPasswordController@reset')->name('password.update');
    });
});

