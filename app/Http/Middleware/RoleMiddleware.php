<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this area.');
        }

        $user = Auth::user();
        if ($user->status !== 'active') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account has been suspended or deactivated.');
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized access to this portal.');
        }

        return $next($request);
    }
}
