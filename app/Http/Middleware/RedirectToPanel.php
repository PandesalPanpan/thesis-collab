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
        /* If even I need to use the App Panel again so user could possibly like have to log in
           Make sure the routes also for redirect the moderator is uncommented*/
        // if (Auth::user() && Auth::user()->role->name === "Moderator"){
        //     return redirect("/moderator");
        // }
        return $next($request);
    }
}
