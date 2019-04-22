<?php

namespace App\Http\Middleware;

use Closure;

class staffSessionCheck
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
        if (!$request->session()->exists('staff')) {
            // user value cannot be found in session
            return redirect('staff_login');
        }
        return $next($request);
    }
}
