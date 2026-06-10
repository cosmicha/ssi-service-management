<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        $role = $user->role ?? 'admin';
        $path = trim($request->path(), '/');

        if (in_array($role, ['customer', 'customer_admin'])) {
            if (
                $path === 'customer-portal' ||
                str_starts_with($path, 'customer-portal/') ||
                $path === 'logout'
            ) {
                return $next($request);
            }

            return redirect('/customer-portal');
        }

        if ($role === 'engineer') {
            if (
                $path === 'engineer' ||
                str_starts_with($path, 'tasks/') ||
                $path === 'logout'
            ) {
                return $next($request);
            }

            return redirect('/engineer');
        }

        return $next($request);
    }
}
