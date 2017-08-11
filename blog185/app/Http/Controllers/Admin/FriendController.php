<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Friend;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // echo "123";  order 排序
        // $arts = Article::paginate(5);
        // $links = Friend::orderBy('link_order')->get();
        /*$links = Friend::paginate(5);
        return view('admin.link.list',compact('links'));*/
         $data = Friend::where('link_name','like','%'.$request['keywords'].'%')->paginate(3);
        $keyword = $request->input('keywords');
//        dd($keyword);
//        keywords => ad
        return view('admin.link.list',compact('data','keyword'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            return view('admin.link.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // 添加友情链接的表单验证
       $input = $request->except('_token');
       $urle = [
            'link_name' => 'required',
            'link_title' => 'required',
            'link_url' => 'required|url',
            'link_order' => 'required|numeric'
       ];
       $mess = [
            'link_name.required' => '名字为必填',
            'link_title.required' => '标题为必填',
            'link_url.required' => 'url地址为必填',
            'link_url.url' => 'url地址不正确',
            'link_order.required' => '排序为必填',
            'link_order.numeric' => '排序为数值',
       ];           
       $validator = \Validator::make($input,$urle,$mess);
//        如果表单验证失败
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
       $res = Friend::create($input);
        if($res){
            return redirect('admin/link');
        }else{
            return back()->with('msg','添加失败');
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
        /*$did = [];
        $did = $id;
        dd($did);*/
       $link =  Friend::find($id);
       // dd($link);
        return view('admin.link.edit',compact('link'));
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
        // echo '123';

        // dd($request->all());
        /*$input = Input::except('_token','_method');
        $link = Friend::find($id);*/
        $input = Input::except('_token','_method');
        // dd($input);
        $link = Friend::find($id);
        $res = $link->update($input);
        if($res){
            return redirect('admin/link');
        }else{
            return back()->with('msg','修改失败');
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
         $re =  Friend::where('link_id',$id)->delete();
//      删除成功
        if($re){
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
        return $data;

    }

    
}
