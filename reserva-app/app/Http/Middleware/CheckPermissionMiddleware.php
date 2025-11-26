<?php

namespace App\Http\Middleware;

use App\Enums\RolePermissionEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (is_null($user)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $role = RolePermissionEnum::from($user->role->value);

        if (!in_array($permission, $role->list())) {
            return response()->json(['message' => 'This action is unauthorized.'], 403);
        }
        return $next($request);
    }
}
