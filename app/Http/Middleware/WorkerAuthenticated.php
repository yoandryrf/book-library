<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRoleEnum;

class WorkerAuthenticated
{
    protected $except = [
        'books.index'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (!in_array($request->route()->getName(), $this->except)) {
                // if user is client take him to his dashboard
                if ($user->hasRole(UserRoleEnum::CLIENT)) {
                    return redirect(route('dashboard'));
                }
            }

            return $next($request);
        }

        abort(403);  // permission denied error
    }
}
