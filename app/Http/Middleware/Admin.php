<?php

namespace App\Http\Middleware;
use Closure;
use Auth;

class Admin {
    function handle($request, Closure $next) {
        if (Auth::check() && Auth::user()->role == 'staff') 
        {
            return redirect ('/staff/staff_pos');
        } 
        elseif (Auth::check() && Auth::user()->role == 'manager') 
        {
            return redirect('/manager/manager_dashboard');
        } 
        elseif (Auth::check() && Auth::user()->role == 'admin') 
        {
            return $next($request);
        }
        else
        {
             return redirect('/');
        }
    }

}
