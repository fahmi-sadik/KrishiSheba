<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BuyerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isBuyer()) {
            abort(403, 'অননুমোদিত অ্যাক্সেস');
        }

        return $next($request);
    }
}
