<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\App;

use Closure;
use Illuminate\Support\Facades\Config;

class Locale
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
         //$raw_locale = Session::get('locale');
         $raw_locale = $request->session()->get('locale');
         $locale = Config::get('app.locale');
           App::setLocale($locale);
           return $next($request);
       }
     }