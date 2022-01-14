<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $langs = config('app.langs');
        $lang = session()->get('lang');
        if (in_array($lang, $langs)){
            app()->setLocale($lang);
        }
        else {
            app()->setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
