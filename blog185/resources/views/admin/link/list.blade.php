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
        <form action="{{url('admin/link')}}" method="get">
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
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/link/create')}}"><i class="fa fa-plus"></i>新增链接</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th class="tc">名字</th>
                        <th class="tc">标题</th>
                        <th class="tc">URL</th>
                        <th class="tc">操作</th>
                    </tr>
                @foreach($data as $k=>$v)
                    <tr>
                        <td class="tc">{{$v->link_id}}</td>
                        <td class="tc">{{$v->link_name}}</td>
                        <td>
                            <a href="#">{{$v->link_title}}</a>
                        </td>
                         <td>
                            <a href="#">{{$v->link_url}}</a>
                        </td>

                        <td>
                            <a href="{{url('admin/link/'.$v->link_id.'/edit')}}">修改</a>
                            <a href="javascript:void(0)" onclick="delUser({{$v->link_id}})">删除</a>
                        </td>
                    </tr>
                @endforeach
                </table>
                {{--<div class="page_list">
                    {!! $links->render() !!}
                </div>--}}

                <div class="page_list">
                    {!! $data->appends(['keywords' => $keyword])->render() !!}
                </div>
    </form>
    <!--搜索结果页面 列表 结束-->
        
   <script>

        function delUser(id){
//询问框
            layer.confirm('确认删除吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
//            layer.msg('删除成功', {icon: 1});
                $.post("{{url('admin/link/')}}/"+id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
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