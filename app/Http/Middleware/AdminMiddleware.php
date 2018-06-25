<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
    	$user = $request->user();
    	if(!$user){
    		return redirect()->guest('/');
    	}
    	elseif($user->role>0){
    		return response('Unauthorized.', 401);
    	}
        return $next($request);
    }
}
