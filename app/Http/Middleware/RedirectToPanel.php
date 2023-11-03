<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectToPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {    
        if (Auth::user() && Auth::user()->role->name === "Admin"){
            return redirect("/admin");
        }
        if (Auth::user() && Auth::user()->role->name === "Moderator"){
            return redirect("/moderator");
        }
        return $next($request);
    }
}
