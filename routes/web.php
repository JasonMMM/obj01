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
});

