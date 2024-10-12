<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class Google2faMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $authenticator = app(Authenticator::class)->boot($request);
        
        if ($authenticator->isAuthenticated()) {
            return $next($request);
        }

        return redirect( route( '2fa' ) );
    }
}
