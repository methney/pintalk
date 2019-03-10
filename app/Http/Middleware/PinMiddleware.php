<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use LRedis;

class PinMiddleware implements Middleware {

    /*
    작성한 PinMiddleware를 Kernel.php에다가 등록한다. 
    https://mattstauffer.co/blog/laravel-5.0-middleware-filter-style 여기참고 
    시험삼아 만들어둔거일뿐 실제사용은 하지 않음. 
    컨트롤러나, routes.php에서 this->middlewhare('pin'); 이런식으로 사용하면 됨.
    */

    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $redis = LRedis::connection();
		$redis->publish('create_user', Auth::user()->email);
        return $response;
    }

    /*
    // before filter
    public function handle($request, Closure $next)
    {
        // <------ 여기다가 구현!!
        return $next($request);
    }
    */

    /*
    // after filter 
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        // <------ 여기다가 구현 
        return $response;
    }


}