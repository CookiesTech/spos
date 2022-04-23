<?php

namespace App\Http\Middleware;
use Closure;
use Auth;

class Staff {

    function handle($request, Closure $next) {
     if (Auth::check() && Auth::user()->role == 'staff') 
        {
             return $next($request);
        } 
        elseif (Auth::check() && Auth::user()->role == 'manager') 
        {
            return redirect('/manager/manager_dashboard');
        } 
        elseif (Auth::check() && Auth::user()->role == 'admin') 
        {
            return redirect('/admin/home');
        }
        else
        {
             return redirect('/');
        }
    }

}