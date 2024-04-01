<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Services\HttpResponse;
use Illuminate\Http\JsonResponse;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ChangePasswordRequest $request): JsonResponse
    {
        $user           = $request->user();
        $user->password = $request->password;
        $user->save();

        return HttpResponse::success(
            message: __('passwords.changed'),
            httpCode: JsonResponse::HTTP_CREATED
        );
    }
}
