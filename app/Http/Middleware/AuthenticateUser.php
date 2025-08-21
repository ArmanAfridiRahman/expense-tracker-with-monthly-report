<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ?string $guard = null): RedirectResponse|Response
    {
        $guard = $guard ?: config('auth.defaults.guard', 'web');
        if (!Auth::guard($guard)->check()) return redirect()->route('login');

        return $next($request);
    }
}
