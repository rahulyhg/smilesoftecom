<?php

namespace App\Http\Middleware;

use Closure;

class warehouseSessionCheck
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
        if (!$request->session()->exists('warehouse')) {
            // user value cannot be found in session
            return redirect('warehouse_login');
        }
        return $next($request);
    }
}
