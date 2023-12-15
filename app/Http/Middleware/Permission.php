<?php

namespace App\Http\Middleware;

use Closure;
use Permissions;

class Permission
{
    public function handle($request, Closure $next, $module = null, $action = null)
    {
        $result = Permissions::Allow($module, $action);
        if ($result) {
            return $next($request);
        }
        if ($request->ajax()) {
            return response()->json(['result' => 'No Permission'], 404);
        } else {
            return abort(404);
        }
    }

    protected function failResponse($request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response('Unauthorized.', 401);
        } else {
            return redirect()->guest('login');
        }
    }
}
