<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Models\User;
use App\Services\HttpResponse;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->only(['email', 'password']))) {
            return HttpResponse::error(
                data: 'Wrong login credentials. Try again',
                httpCode: JsonResponse::HTTP_UNAUTHORIZED
            );
        }
        /**
         * @var User $user
         */
        $user = User::query()->firstWhere('email', $request->email);
        $user->load(['roles']);
        $user->append('ownedTeam');
        $token    = $user->createAccessToken();
        $response = new AuthResource($user, $token);

        return HttpResponse::success(
            data: $response,
        );
    }
}
