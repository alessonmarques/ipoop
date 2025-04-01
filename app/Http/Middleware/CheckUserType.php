<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    public function handle(Request $request, Closure $next, $type)
    {
        if (!auth()->check() || auth()->user()->type !== $type) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}