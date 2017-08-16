<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Validator;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    //登录首页
    public function index()
    {
        return view('admin/index');
    }

    //后台首页信息模块
    public function info()
    {
        return view('admin/info');
    }

    //退出登录
    public function quit()
    {
        session(['user'=>null]);

    //或者清空session中的所有数据
    //session()->flush();
        return redirect('admin/login');
    }

    //修改密码
    public function pass()
    {
    //返回修改密码页面视图
        return view('admin/pass');
    }

    //修改密码业务逻辑
    public function dopass()
    {

          $input = Input::except('_token');

    //验证规则
        $rule = [
            'password_o'=>'required|between:6,18',
            'password'=>'required|between:6,18',
            'password_c'=>'required|same:password',
        ];

    //提示信息
        $mess = [
            'password_o.required'=>'原密码必须输入',
            'password_o.between'=>'原密码必须在6-18位之间',
            'password.required'=>'新密码必须输入',
            'password.between'=>'新密码必须在6-18位之间',
            'password_c.same'=>'两次密码不一致请重新输入',
        ];

        //判断原密码 新密码是否符合正则验证规则 表单验证
        //  Validator::make(要验证的数据,验证规则,错误的提示方式);
        $validator = validator::make($input,$rule,$mess);
        //如果验证失败
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

 //       1 判断原密码是否正确
         // dd(session('user')->user_id);
       $user = User::find(session('user')->user_id);
         // $user = User::first();
        // dd($user);
        // dd(session('user'));

        if($input['password_o'] != Crypt::decrypt($user->user_pass)){
            return back()->with('errors','原密码输入错误');
        }

        
        //修改密码
            $pass = Crypt::encrypt($input['password']);
        // dd($pass);
       $re = \DB::table('user')->where('user_id',$user->user_id)->update(['user_pass'=>$pass] );
        // $re = $user->save();

        //如果修改成功
        if($re){
            return back()->with('errors','密码修改成功');
        } else {
            return back()->with('errors','密码修改失败');
        }


}
}
