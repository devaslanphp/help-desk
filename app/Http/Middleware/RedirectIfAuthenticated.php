<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role = Auth::user()->role;
                switch ($role) {
                    case 'administrator':
                        return redirect('/analytics');
                        break;
                    case 'Head of Department':
                        return redirect('/tickets');
                        break;   
                    case 'technician':
                        return redirect('/tickets');
                        break;
                    case 'Human Resources':
                        return redirect('/tickets');
                        break;    
                    case 'user':
                        return redirect('/tickets');
                        break;
                }
            }
        }

        return $next($request);
    }
}
