<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ManagerCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(session('employee')->position !== 'Manager' ){
            abort(404,'File Not Fount');
        }
        return $next($request);
    }
}
