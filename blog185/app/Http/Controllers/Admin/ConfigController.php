<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Model\Config;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public function putFile()
    {
        //获取要呗写去的内容
        $con = Config::lists('conf_content','conf_name')->all();

        $str= '<?php   return '.var_export($con,true).';';

        file_put_contents(base_path().'/config/web.php',$str);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // echo "123";
        // $config = Config::orderBy('conf_order','asc')->get();
        // $data = Config::get();
        // dd($data);
        // $arts = Config::paginate(5);  //5表示每页显示条数

        $config = Config::where('conf_title','like','%'.$request['keywords'].'%')->paginate(3);
       /* $keyword = $request->input('keywords');*/

        // return view('admin.config.list',compact('config','arts'));


       // $config = Config::paginate(5);
        //dd($config);
        foreach($config as $k=>$v){
            switch($v->field_type){
                case 'input':
                   $config[$k]['_content'] = ' <input class="lg" type="text" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $config[$k]['_content'] = '  <textarea class="lg"  name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':

//                    1|开启,0|关闭
                    $arr = explode(',',$config[$k]->field_value);
                    $str ='';
                    foreach($arr as $m=>$n){
                       $r = explode('|',$n);
                        $c =   ($config[$k]->conf_content == $r[0]) ? 'checked' : '';
                       $str.= ' <input type="radio"  name="conf_content[]"'.$c.' value="'.$r[0].'">'.$r[1];
                    }
                    $config[$k]['_content'] = $str;
                    break;
            }
        }
        return view('admin.config.list',compact('config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.config.add');
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
        $input = $request->except('_token');
        // dd($input);
        $res = Config::create($input);

        if($res){

            return redirect('admin/config');
        }else {
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
        //
         // $config = Config::first($id);
         $config = Config::where('conf_id',$id)->first();
         // dd($config);
        return view('admin.config.edit',compact('config'));
    }

    /**
     * Update the specified resource in storage.
     *er
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

         $config = Config::find($id);
        // $config = \DB::table('config')->all($id);

         // dd($config);
      // $config = Config::where('conf_id',$id)->first();
      $input = $request->except('_token','_method');
      
       $re = $config->update($input);
        if($re){
            $this->putFile();
            return redirect('admin/config');
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
       $re = Config::where('conf_id',$id)->delete();
        if($re){
            $this->putFile();
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
