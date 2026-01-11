<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CrmAccessMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return $next($request);
        }

        // Only attempt auto-login in local environment and when enabled
        if (App::environment('local') && Config::get('crm.dev_auto_login', true)) {
            // Find first active user with role name 'admin'
            $user = User::where('is_active', true)
                ->whereHas('role', function ($q) {
                    $q->whereRaw('LOWER(name) = ?', ['admin']);
                })
                ->first();

            if ($user) {
                Auth::login($user);
                return $next($request);
            }

            abort(500, 'No admin user seeded');
        }

        abort(403, 'CRM requires authentication');
    }
}
