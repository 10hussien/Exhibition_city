<?php

namespace App\Http\Middleware;

use App\Models\Profile;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{

    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->user()->status == 'admin') {
            return $next($request);
        } else {
            return response()->json(__('words.You do not have the authority to modify these company'));
        }
    }
}
