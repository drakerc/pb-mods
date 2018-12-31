<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!backpack_user()->is_admin) {
            return response(trans('backpack::base.unauthorized'), 401);
        }

        return $next($request);
    }
}
