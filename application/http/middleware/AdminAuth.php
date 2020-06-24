<?php

namespace app\http\middleware;


class AdminAuth
{
    public function handle($request, \Closure $next)
    {
        if (session('?username')==false){
            return redirect('/');
        }
        $request->username=session('username');
        return $next($request);
    }
}
