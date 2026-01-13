<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as RouteFacade;

class EnsureCrmRoleRedirect
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user) {
            // For any CRM request, always send guests to CRM login
            if ($request->is('crm/*') || $request->is('crm')) {
                if (RouteFacade::has('crm.login')) {
                    return redirect()->route('crm.login');
                }
                return redirect('/');
            }

            // Non-CRM fallback: attempt app login route if available
            if (RouteFacade::has('login')) {
                return redirect()->route('login');
            }
            return redirect('/');
        }

        // Determine role string
        $roleName = null;
        if (is_string($user->role)) {
            $roleName = $user->role;
        } elseif (is_object($user->role) && isset($user->role->name)) {
            $roleName = $user->role->name;
        }

        $userRole = null;
        if ($roleName === 'admin') {
            $userRole = 'admin';
        } elseif ($roleName === 'sales') {
            $userRole = 'sales';
        }

        // Detect required area from path
        $path = ltrim($request->path(), '/');
        $requiredRole = null;
        if (str_starts_with($path, 'crm/admin')) {
            $requiredRole = 'admin';
        } elseif (str_starts_with($path, 'crm/sales')) {
            $requiredRole = 'sales';
        }

        // Unknown user role -> friendly CRM 403
        if (is_null($userRole)) {
            return response()->view('crm.errors.403', [], 403);
        }

        // If requiredRole exists and doesn't match, redirect to correct dashboard
        if ($requiredRole && $requiredRole !== $userRole) {
            if ($userRole === 'admin') {
                return redirect()->route('crm.admin.dashboard');
            }
            if ($userRole === 'sales') {
                return redirect()->route('crm.sales.dashboard');
            }
        }

        return $next($request);
    }
}
