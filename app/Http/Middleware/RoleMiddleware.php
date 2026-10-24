<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string $role
    ): Response {
        if (!$request->user() || (int) $request->user()->role !== (int) $role) {
            abort(403, 'Nincs jogosultságod az oldal megtekintéséhez.');
        }

        return $next($request);
    }
}