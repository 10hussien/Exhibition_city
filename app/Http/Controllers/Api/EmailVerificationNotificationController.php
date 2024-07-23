<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Cache;


class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => __('validation.Your account has already been confirmed')]);
        }

        $randomNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        VerifyEmail::toMailUsing(function (object $notifia) use ($randomNumber) {
            return (new MailMessage)
                ->subject('Verify Email')
                ->line(__('validation.This code was sent to verify the validity of your email'))
                ->line($randomNumber)
                ->line(__('validation.This Verify email code will expire in 60 minutes'));
        });
        $request->user()->sendEmailVerificationNotification();
        Cache::put('randomNumber', $randomNumber, 1000);

        return response()->json(['status' => __('validation.The code has been sent to your email')]);
    }
}
