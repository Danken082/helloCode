<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            // No user logged in => this is a guest
            if ($role === 'guest') {
                return $next($request);  // Allow guests
            } else {
                // If role expected is not guest but user is guest, deny access
                abort(403);
            }
        }
    
        // User is logged in
        $user = Auth::user();
    
        if ($role === 'guest') {
            // User is logged in but route only for guests
            return redirect('/shop/home'); // or wherever logged-in users go
        }
    
        if ($user->role !== $role) {
            abort(403);
        }
    
        return $next($request);    }
}
