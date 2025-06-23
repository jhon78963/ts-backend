<?php

namespace App\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public const HEADER_ROLE = 'X-Role';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $excludedRoutes = [
            'api/auth/login',
            'api/auth/refresh-token',
            'api/auth/logout',
        ];

        if (in_array($request->path(), $excludedRoutes)) {
            return $next($request);
        }

        if (!$request->user()) {
            abort(401, 'Unauthorized');
        }

        $role = $request->header(self::HEADER_ROLE);
        $userRole = $request->user()->role?->name;

        if ($role && $userRole !== $role) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        return $next($request);
    }
}
