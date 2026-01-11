<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:admin') or 'role:admin,sales'
     */
    public function handle(Request $request, Closure $next, ?string $roles = null): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if (! $roles) {
            return $next($request);
        }

        $allowed = array_map('trim', explode(',', $roles));
        $roleName = $user->role ? strtolower($user->role->name) : null;

        if (! $roleName || ! in_array($roleName, array_map('strtolower', $allowed), true)) {
            abort(403);
        }

        return $next($request);
    }
}
