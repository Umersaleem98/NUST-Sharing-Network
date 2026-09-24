<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveProfileStatus
{
    /*
    |--------------------------------------------------------------------------
    | Handle Request
    |--------------------------------------------------------------------------
    */

    public function handle(
        Request $request,
        Closure $next
    ): Response {
        /*
        |--------------------------------------------------------------------------
        | User Not Logged In
        |--------------------------------------------------------------------------
        */

        if (!Auth::check()) {

            return $next(
                $request
            );
        }


        $user =
            Auth::user();


        /*
        |--------------------------------------------------------------------------
        | Suspended Account
        |--------------------------------------------------------------------------
        */

        if (
            $user->profile_status ===
            'suspended'
        ) {

            Auth::logout();


            $request
                ->session()
                ->invalidate();


            $request
                ->session()
                ->regenerateToken();


            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'Your account has been suspended. Please contact the administrator for assistance.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Blocked Account
        |--------------------------------------------------------------------------
        */

        if (
            $user->profile_status ===
            'blocked'
        ) {

            Auth::logout();


            $request
                ->session()
                ->invalidate();


            $request
                ->session()
                ->regenerateToken();


            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'Your account has been blocked. Please contact the administrator for assistance.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Active User
        |--------------------------------------------------------------------------
        */

        return $next(
            $request
        );
    }
}