<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        $knownRoles = [
            User::ROLE_PELAPOR,
            User::ROLE_PEMANTAU,
            User::ROLE_KOORDINATOR,
        ];

        if (
            $user === null
            || ! in_array($user->role, $knownRoles, true)
            || ! in_array($user->role, $roles, true)
        ) {
            abort(403);
        }

        return $next($request);
    }
}
