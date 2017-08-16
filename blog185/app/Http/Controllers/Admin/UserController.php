<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Model\User;
use App\Http\Model\Detail;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     //
     //   推荐 第三种 方法 compact()
     
        /*$data = User::paginate(3);
        return view('admin.user.list',compact('data'));*/
       // $data = User::paginate(3);
        $data = User::where('user_name','like','%'.$request['keywords'].'%')->paginate(3);
       // dd($data);
         $keyword = $request->input('keywords');
         // dd($keyword);
         return view('admin.user.list',compact('data','keyword'));
        // dd($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //用户添加页
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //接收添加的用户信息
        // dd($request->all());
        $input = $request->except(['_token']);
        // dd($input);

//          $rule = [
//             'user_name'=>'required|between:5,18',
//             'user_pass'=>'required|between:6,18',
//             'user_phone'=>'required|regex:/^1[3578]\d{9}$/',
//             'user_email'=>'required|email'
//         ];
//         $mess = [
//             'user_name.required'=>'用户名必须输入',
//             'user_name.between'=>'用户名必须在5-18位之间',
//             'user_pass.required'=>'密码必须输入',
//             'user_pass.between'=>'密码必须在6-18位之间',
//             'user_phone.required'=>'手机号必须输入',
//             'user_phone.regex'=>'手机号格式不正确',
//             'user_email.email'=>'邮箱格式不正确',
//             'user_email.required'=>'邮箱必须输入'

//         ];
        
//         $validator = Validator::make($input,$rule,$mess);
// //        如果表单验证失败
//         if($validator->fails()){
//             return back()->withErrors($validator)->withInput();
//         }
        $input = (object)$input;
        // dd($input);


         //上传头像
        $imgs = (object)$input->user_pic;
        // $file = $request->file('user_pic');
        // $imgs = $request['user_pic'];
        // dd($imgs);

        if ($imgs) {

            //上传文件的名字
            $name = rand(1111,9999).time();
            // dd($name);
            //获取后缀  $_FILES['pic']
            // $suffix = $input->file('user_pic')->getClientOriginalExtension();
            $suffix = $request->file('user_pic')->getClientOriginalExtension();
             dd($suffix);
            //
            $input->file('user_pic')->move('./uploads', $name.'.'.$suffix);
        }

        

        //存入到数据库
        $res['user_pic'] = '/uploads/'.$name.'.'.$suffix;




//        添加用户
        $input['user_pass'] = Crypt::encrypt($input['user_pass']);
        $re = User::create($input);
//        如果添加成功 跳转到用户列表页
        if($re){
            return redirect('admin/user');
        }else{
            return back()->with('errors','用户添加失败');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
       $user =  User::find($id);
       
       return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request->all());
         $input = $request->except('_token','_method');

         $rule = [
            'user_name'=>'required|between:5,18',
            'user_phone'=>'required|regex:/^1[3578]\d{9}$/',
            'user_email'=>'required|email'
        ];
        $mess = [
            'user_name.required'=>'用户名不能为空',
            'user_name.between'=>'用户名必须在5-18位之间',
            'user_phone.required'=>'手机号不能为空',
            'user_phone.regex'=>'手机号格式不正确',
            'user_email.email'=>'邮箱格式不正确',
            'user_email.required'=>'邮箱不能为空'

        ];
        $validator = Validator::make($input,$rule,$mess);
//        如果表单验证失败
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
         // dd($input);
         $user = User::find($id);
        $re = $user->update($input);

          if($re){
//          修改成功，返回用户列表页
            return redirect('admin/user');
        }else{
            return back()->with('errors','用户修改失败');
        }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $re = User::where('user_id',$id)->delete();
        //   删除成功
      if($re){
          // $re = Detail::where('detail_id',$v->users_id)->delete();
          $data = [
              'status'=>0,
              'msg'=>'删除成功',
          ];
      }else{
          $data = [
              'status'=>1,
              'msg'=>'删除失败',
          ];
      }

//      return $data;
      return response()->json($data);
//      return json_encode($data);
       return  json_parse($data);
    }
}
