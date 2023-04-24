<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRoleEnum;

class WorkerAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // if user is not admin take him to his dashboard
            if ($user->hasRole(UserRoleEnum::CLIENT)) {
                return redirect(route('dashboard'));
            }

            return $next($request);
        }

        abort(403);  // permission denied error
    }
}
