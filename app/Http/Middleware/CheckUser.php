<?php

namespace App\Http\Middleware;

use Closure;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     *
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->get('user') === null) {
          \Session::put('previous_url',url()->current());

          return redirect()->route('home');
        }

        \Config::set('database.connections.mysql2.username', $request->session()->get('user'));
        \Config::set('database.connections.mysql2.password', $request->session()->get('clave'));
        \DB::disconnect('mysql');
        \DB::connection('mysql2');

        return $next($request);
    }
}
