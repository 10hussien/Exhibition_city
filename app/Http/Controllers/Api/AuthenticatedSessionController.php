<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{

    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();
        $user=$request->user();

            $user->tokens()->delete();
            $token=$user->createToken('Exhibition_city');

            return response()->json([
                'Token'=>$token->plainTextToken,
                'user'=>$user,
                'status'=>200]);

        }


    public function destroy(Request $request):JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['status'=>200]);

    }
}
