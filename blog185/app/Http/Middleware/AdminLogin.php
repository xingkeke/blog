<?php

namespace App\Http\Middleware;

use Closure;

class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //如果用户没有登录,反回到登录页面

        if(!session('user')){
            return redirect('admin/login');
        }
        return $next($request);
    }
}
