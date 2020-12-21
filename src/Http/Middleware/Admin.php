<?php
namespace WFN\Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{

    public function handle($request, Closure $next, $state = '')
    {
        if(!Auth::guard('admin')->check() && $state == 'auth') {
            return redirect(env('ADMIN_PATH', 'admin') . '/login');
        }

        if(Auth::guard('admin')->check() && $state == 'guest') {
            return redirect(env('ADMIN_PATH', 'admin') . '/dashboard');
        }

        return $next($request);
    }
}
