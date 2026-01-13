<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CrmAuthenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // If user is authenticated, continue
        if (Auth::check()) {
            return $next($request);
        }

        // If this is a CRM request, show custom CRM auth page (401)
        if ($request->is('crm/*') || $request->is('crm')) {
            return response()->view('crm.errors.auth', [], 401);
        }

        // Non-CRM fallback: try normal login route if present
        if (Route::has('login')) {
            return redirect()->route('login');
        }

        return redirect('/');
    }
}
