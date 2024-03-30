<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Services\HttpResponse;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        /**
         * @var \App\Models\User $user
         */
        $user = User::query()->firstWhere('email', $request->email);
        $user->resetPassword($request->password, $request->token);

        return HttpResponse::success(__('passwords.reset'));
    }
}
