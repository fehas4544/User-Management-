<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Allow Admin, Manager, and Staff roles
        $allowedRoles = ['Admin', 'Manager', 'Staff'];
        
        // Check if user has allowed role via role column OR via Spatie roles
        $hasRoleColumn = in_array($user->role, $allowedRoles);
        $hasSpatieRole = $user->hasAnyRole($allowedRoles);
        
        if (!$hasRoleColumn && !$hasSpatieRole) {
            abort(403, 'Unauthorized access. You need Admin, Manager, or Staff privileges.');
        }

        return $next($request);
    }
}
