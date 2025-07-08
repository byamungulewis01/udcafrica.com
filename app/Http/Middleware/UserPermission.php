<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $user = $request->user();

        if (!$user) {
            return Inertia::render('Errors/AccessDenied', [
                'message' => 'You must be logged in to access this resource.',
            ])->toResponse($request)->setStatusCode(403);
        }

        $userPermissions = $user->permissions ?? [];

        // Permissions is already cast to an array
        if (!is_array($userPermissions)) {
            $userPermissions = [];
        }

        foreach ($permissions as $permission) {
            if (in_array($permission, $userPermissions)) {
                return $next($request);
            }
        }

        return Inertia::render('Errors/AccessDenied', [
            'message' => 'You do not have permission to access this resource.',
        ])->toResponse($request)->setStatusCode(403);
    }
}
