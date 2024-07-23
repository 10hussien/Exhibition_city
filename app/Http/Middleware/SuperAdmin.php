<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{

    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->user()->status == 'super_admin') {
            return $next($request);
        } else {
            return response()->json(['error' => __('words.You do not have the right to add the department')]);
        }
    }
}
