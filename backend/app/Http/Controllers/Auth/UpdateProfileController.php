<?php

namespace App\Http\Controllers\Auth;

use App\Dto\Auth\UpdateProfileDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Services\HttpResponse;
use Illuminate\Http\JsonResponse;

class UpdateProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateProfileRequest $request): JsonResponse
    {
        $requestPayload = UpdateProfileDto::fromRequest($request)->toArray();
        /**
         * @var \App\Models\User $user
         */
        $user = $request->user();
        $user->updateOrFail($requestPayload);
        return HttpResponse::success(
            message: __('user.profile_updated'),
            data: $user->name,
            httpCode: JsonResponse::HTTP_CREATED
        );
    }
}
