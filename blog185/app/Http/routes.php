<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

//登录路由
Route::get('admin/login','Admin\LoginController@login');

//组件验证码路由
Route::get('/code/captcha/{tmp}', 'Admin\LoginController@captcha');

Route::post('admin/login','Admin\LoginController@dologin');

//加密路由
Route::get('admin/crypt','Admin\LoginController@crypt');

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'login.admin'],function(){

//后台首页页面
Route::get('index','IndexController@index');

Route::get('info','IndexController@info');

//退出登录
Route::get('quit','IndexController@quit');

//修改密码
Route::get('pass','IndexController@pass');

//修改密码业务逻辑
// Route::post('pass','IndexController@dopass');

});

