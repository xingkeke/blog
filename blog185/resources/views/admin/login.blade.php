@extends('layouts.admin')
@section('title', '后台登录页面')
@section('content')
<body style="background:#F3F3F4;">
	<div class="login_box">
		<h1>Blog</h1>
		<h2>欢迎使用博客管理平台</h2>
		<div class="form">
			@if(session('error'))
			<p style="color:red">{{session('error')}}</p>
			@endif

			<form action="{{url('admin/login')}}" method="post">
			{{csrf_field()}}
				<ul>
					<li>
					<input type="text" name="user_name" class="text"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="user_pass" class="text"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<!-- 第二种验证码 -->
						<input type="text" class="code" name="code"/>
						<a onclick="javascript:re_captcha();">  
						<img src="{{ URL('/code/captcha/1') }}" id="127ddf0de5a04167a9e427d883690ff6">  
</a>  
					</li>
					
					<li>
						<input type="submit" value="立即登陆"/>
					</li>
				</ul>
			</form>
			<p><a href="#">返回首页</a> &copy; 2016 Powered by <a href="http://www.itxdl.cn" target="_blank">http://www.itxdl.cn</a></p>
		</div>
	</div>
	<!-- Js点击换验证码 -->
	<script type="text/javascript">  
	function re_captcha() {  
    $url = "{{ URL('/code/captcha') }}";
    $url = $url + "/" + Math.random();
        document.getElementById('127ddf0de5a04167a9e427d883690ff6').src = $url;
    }
</script>

</body>

@endsection
