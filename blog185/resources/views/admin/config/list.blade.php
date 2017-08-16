@extends('layouts.admin')

@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">系统设置</a> &raquo; 友情链接列表
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
                <form action="{{url('admin/config')}}" method="get">
                    <table class="search_tab">
                        <tr>
                            <th width="70">关键字:</th>
                            <td><input type="text" name="keywords" placeholder="关键字" value="{{isset($keyword)?$keyword:''}}"></td>
                            <td><input type="submit" name="sub" value="查询"></td>
                        </tr>
                    </table>
                </form>
            </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/config/changecontent')}}" method="post">
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
            {{csrf_field()}}
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>

                    @foreach($config as $k=>$v)
                    <tr>
                        <td class="tc">{{$v->conf_id}}</td>
                        <td class="">{{$v->conf_title}}</td>
                        <td>
                            <a href="#">{{$v->conf_name}}</a>
                        </td>
                        <td>
                            <input type="hidden" name="conf_id[]" value="{{$v->conf_id}}">
                            <a href="#">{!! $v->_content !!}</a>
                        </td>

                        <td>
                            <a href="{{url('admin/config/'.$v->conf_id.'/edit')}}">修改</a>
                            <a href="javascript:void(0)" onclick="delUser({{$v->conf_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>

                        <td colspan="5">
                            <input type="submit" value="提交">

                        </td>
                    </tr>

                </table>
                <div class="page_list">         
                        {!! $config->render() !!}
                    </div> 
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
        
    <script>

        function delUser(id){
//            参数1 要请求的服务器路由
//            参数2 请求要携带的参数数据  _method：delete  _token
//              参数3 回调函数,回调函数的参数data表示服务器返回的数据
//            $.post(URL,data,callback);
//询问框
            layer.confirm('确认删除吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
//            layer.msg('删除成功', {icon: 1});
                $.post("{{url('admin/config/')}}/"+id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
//                console.log(data);
                    if(data.status == 0){
                        location.href = location.href;
                        layer.msg('删除成功', {icon: 5});
                    }else{
                        location.href = location.href;
                        layer.msg('删除失败', {icon: 6});
                    }

                });

            }, function(){

            });

        }


    </script>

</body>

@endsection