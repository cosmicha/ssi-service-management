<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $role = auth()->user()?->role;

        abort_unless(
            in_array($role, [
                'admin',
                'system_admin',
                'service_manager',
            ]),
            403,
            'Unauthorized'
        );

        return $next($request);
    }
}
