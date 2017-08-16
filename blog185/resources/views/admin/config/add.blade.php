@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">用户管理</a> &raquo; 添加用户
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
        <form action="{{url('admin/config')}}" method="post">
            <table class="add_tab">
                {{csrf_field()}}
                <tbody>
                <tr>
                    <th>标题：</th>
                    <td>
                        <input type="text" name="conf_title">
                    
                    </td>
                </tr>
                <tr>
                    <th>名字：</th>
                    <td>
                        <input type="text" name="conf_name">
                       
                    </td>
                </tr>
                <tr>
                    <th>内容：</th>
                    <td>
                        <textarea class="lg"  name="conf_content"></textarea>
                    </td>
                </tr>
                <tr>
                    <th>类型：</th>
                    <td>
                        <label for=""><input type="radio" onclick="showTr()" name="field_type" value="input">input</label>
                        <label for=""><input type="radio" onclick="showTr()" name="field_type" value="textarea">textarea</label>
                        <label for=""><input type="radio" onclick="showTr()" name="field_type" value="radio">radio</label>
                    </td>
                </tr>
                <tr class="field_value">
                    <th>类型值：</th>
                    <td>
                        <input type="text" name="field_value">
                        <span><i class="fa fa-exclamation-circle yellow">类型值只有在radio的情况下才需要配置，格式 1|开启,0|关闭</i></span>
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" name="conf_order">
                       
                    </td>
                </tr>
                <tr>
                    <th>说明：</th>
                    <td>
                        <textarea class="lg"  name="conf_tips"></textarea>
                        <p>标题可以写30个字</p>
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
    <script>
        showTr();
        function showTr(){
           var v=  $('input[name=field_type]:checked').val();
           if(v == 'radio'){
               $('.field_value').show();
           }else{
               $('.field_value').hide();
           }
        }
    </script>
</body>
@endsection