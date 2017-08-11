<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Model\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Gregwar\Captcha\CaptchaBuilder; 
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Input; 
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    *方法的功能:返回后台登录页面
    *@author:xxx
    *方法需要的参数
    *return 返回值
    *@data 时间
    */
    public function login(){
        return view('admin/login');
    }

    // 验证码生成
public function captcha($tmp)
{

    $phrase = new PhraseBuilder;
    // 设置验证码位数
    $code = $phrase->build(4);
    // 生成验证码图片的Builder对象，配置相应属性
    $builder = new CaptchaBuilder($code, $phrase);
    // 设置背景颜色
    $builder->setBackgroundColor(220, 210, 230);
    $builder->setMaxAngle(25);
    $builder->setMaxBehindLines(0);
    $builder->setMaxFrontLines(0);
    // 可以设置图片宽高及字体
    $builder->build($width = 100, $height = 40, $font = null);
    // 获取验证码的内容
    $phrase = strtoupper($builder->getPhrase());
    // 把内容存入session
    \Session::flash('code', $phrase);
    // 生成图片
    header("Cache-Control: no-cache, must-revalidate");
    header("Content-Type:image/jpeg");
    $builder->output();
    }

    public function dologin(Request $request)
    {
        // 1.获取到用户提交的数据
        // dd($request->all());
        // $input = $request->except('_token');
        // dd($input);

        $input = Input::except('_token');
        // dd($input);

        // 2.验证用户名 密码 验证码
        // $users = DB::table('user')->select('user_name','emailas user_emaila')->get();
        $user = user::where('user_name',$input['user_name'])->first();
        // dd($user);
        if(!$user) {
            return back()->with('error','无此用户');
        }

        //密码加密
        // $input['user_pass'] = Crypt::encrypt($input['user_pass']);

        if(Crypt::decrypt($user->user_pass) !=trim($input['user_pass']) ){
            return back()->with('error','密码错误');
        }

        //验证码
        if(strtoupper($input['code']) != session('code')){
            return back()->with('error','验证码错误');
        }


        // 3.登录成功保存登录状态跳转到后台首页

        session(['user'=>$user]);

        return redirect('/admin/index');

        //4.登录失败跳转登录页

    }

    // 加密方式
    public function crypt()
    {
        //第二种
       /* $str = '123456';
       echo crypt::encrypt($str);*/

       //第三种Hash
       // echo Hash::make('123456');

       // $str = bcrypt('123456');

       if(Hash::check('123456',$str)){
        echo "真";
       } else{
        echo "假";
       }

    }

}
