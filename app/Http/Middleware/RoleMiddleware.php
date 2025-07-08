<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // if(auth()->user() && auth()->user()->role !== 'admin') {
        //     abort(403, 'Unauthorized access.'); }

        if (!auth()->check()) {
            return redirect('/login');
        }

        $userRole = auth()->user()->role;

        if (auth()->user()->role !== 'admin' && !in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
