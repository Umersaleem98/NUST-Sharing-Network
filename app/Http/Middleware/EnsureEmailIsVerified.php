<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        if (!auth()->check()) {

            return redirect()
                ->route('login');
        }

        if (!auth()->user()->hasVerifiedEmail()) {

            return redirect()
                ->route('verification.notice')
                ->with(
                    'warning',
                    'Please verify your email address first.'
                );
        }

        return $next($request);
    }
}
