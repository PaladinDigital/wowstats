<?php namespace WoWStats\Http\Middleware;

use \Auth;
use Closure;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('home');
        }

        $user = Auth::user();

        if (!$user->isAdmin()) {
            return redirect('home');
        }
            
        return $next($request);
    }
}
