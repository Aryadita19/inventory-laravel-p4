<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Authorization di server: dipakai di route sebagai EnsureRole::class.':admin' */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        abort_unless($user && in_array($user->role, $roles, true), 403, 'Role Anda tidak diizinkan membuka halaman ini.');

        return $next($request);
    }
}
