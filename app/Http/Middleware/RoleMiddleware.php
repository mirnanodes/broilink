<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return response()->json(['message' => 'Unauthorized: User not authenticated.'], Response::HTTP_UNAUTHORIZED);
        }
        
        $userRoleName = $request->user()->role->name ?? null;

        if (! in_array($userRoleName, $roles)) {
            return response()->json(['message' => 'Forbidden: Akses ditolak untuk peran Anda.'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}