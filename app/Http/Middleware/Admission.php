<?php

namespace App\Http\Middleware;

use App\Models\CompanyInformation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admission
{

    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        $company = CompanyInformation::find($id);
        if ($company->admission == 'accepted') {
            return $next($request);
        } else {
            return response()->json(['error' => __('words.This company does not actually exist')], 404);
        }
    }
}
