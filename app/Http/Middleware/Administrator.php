<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Administrator
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // если это не администратор — показываем 404 Not Found
        if (!auth()->user()->admin) {
            abort(404);
        }
        return $next($request);
    }
}
