<?php

namespace App\Http\Middleware;
use Closure;
use Auth;

class Manager {

    function handle($request, Closure $next) {
      if (Auth::check() && Auth::user()->role == 'staff') {
            return redirect ('/staff/staff_pos');
        } elseif (Auth::check() && Auth::user()->role == 'manager') {
            return $next($request);
        } elseif (Auth::check() && Auth::user()->role == 'admin') {
            return redirect('/admin/home');
        }
        else
        {
             return redirect('/');
        }
    }

}