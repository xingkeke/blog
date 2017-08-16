@extends('layouts.admin')

@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">友情链接管理</a> &raquo; 添加友情链接
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if(session('msg'))
                <div class="mark">
                    <ul>
                        <li>{{ session('msg') }}</li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="#"><i class="fa fa-plus"></i>新增用户</a>
                <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/link/'.$link->link_id)}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="put">
            <table class="add_tab">
                <tbody>                  
                    <tr>
                        <th>名字：</th>
                        <td>
                            <input type="text" name="link_name" value="{{$link->link_name}}">
                            <span><i class="fa fa-exclamation-circle yellow"></span>
                        </td>
                    </tr>
                    <tr>
                        <th>标题：</th>
                        <td>
                            <input type="text" name="link_title" value="{{$link->link_title}}">
                            <span><i class="fa fa-exclamation-circle yellow"></span>
                        </td>
                    </tr>
                    <tr>
                        <th>url地址：</th>
                        <td>
                            <input type="text" name="link_url" value="{{$link->link_url}}">
                            <span><i class="fa fa-exclamation-circle yellow"></span>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" name="link_order" value="{{$link->link_order}}">
                            <span><i class="fa fa-exclamation-circle yellow"></span>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

</body>
@endsection()
