<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendPasswordResetTokenRequest;
use App\Models\User;
use App\Services\HttpResponse;
use Illuminate\Http\Request;

class SendPasswordResetTokenController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SendPasswordResetTokenRequest $request)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = User::query()->firstWhere('email', $request->email);
        $user->sendPasswordResetToken();

        return HttpResponse::success(
            message: __('passwords.sent'),
        );
    }
}
