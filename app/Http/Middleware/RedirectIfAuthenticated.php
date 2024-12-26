<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

//Bu middleware oturum açmış kullanıcıları belirli sayfalara yönlendirmek için kullnılır.

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/home'); // Oturum açmışsa yönlendirme yapılır.
        // }

        return $next($request);
    }
}
