<?php

namespace App\Http\Middleware;

use App\Models\CompanyInformation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CompanyControl
{

    public function handle(Request $request, Closure $next)
    {
        $id = $request->route('id');
        $company_owner = CompanyInformation::find($id);
        if ($company_owner) {
            $Current_user = Auth::user()->id;
            if ($company_owner->user_id != $Current_user) {
                return response()->json(['error' => __('words.You do not have the authority to modify these company')], 404);
            }
            return $next($request);
        } else {
            return response()->json(['error' => __('words.This company does not actually exist')], 404);
        }
    }
}
