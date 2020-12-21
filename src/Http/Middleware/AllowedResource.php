<?php
namespace WFN\Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AllowedResource
{

    public function handle($request, Closure $next)
    {
        if(!Auth::guard('admin')->user()->role->isAvailable($request->route()->getName())) {
            return abort(404);
        }

        return $next($request);
    }
}
