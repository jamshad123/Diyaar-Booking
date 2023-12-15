<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FilterIpOrMacAddress
{
    public $whiteListIps = [
        '192.168.0.5',
    ];

    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->getClientIp(), $this->whiteListIps)) {
            abort(403, 'You are restricted to access the site.');
        }

        return $next($request);
    }
}
