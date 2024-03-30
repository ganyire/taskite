<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendEmailVerificationCodeRequest;
use App\Models\User;
use App\Services\HttpResponse;
use Illuminate\Http\JsonResponse;

class SendEmailVerificationCodeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SendEmailVerificationCodeRequest $request): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = User::query()->firstWhere('email', $request->email);
        if ($user->hasVerifiedEmail()) {
            return HttpResponse::error(
                data: 'Your email address has already been verified',
                httpCode: JsonResponse::HTTP_BAD_REQUEST
            );
        }
        $user->sendEmailVerificationCode();

        return HttpResponse::success(
            message: 'Verification code has been sent to your email address',
        );
    }
}
