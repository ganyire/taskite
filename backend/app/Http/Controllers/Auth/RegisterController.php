<?php

namespace App\Http\Controllers\Auth;

use App\Dto\Auth\RegisterDto;
use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Notifications\Auth\AccountRegisteredNotification;
use App\Services\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $payload = RegisterDto::fromRequest($request);

        DB::beginTransaction();
        try {
            /**
             * @var User $user
             */
            $user      = User::query()->create($payload->toArray());
            $ownedTeam = $user->teams()->create(
                [
                    'name'         => $payload->teamName,
                    'display_name' => $payload->teamDisplayName,
                ],
                ['is_owner' => true]
            );
            $user->addRole(RolesEnum::OWNER, $ownedTeam);
            $user->append('ownedTeam');
            $token = $user->createAccessToken();
            auth()->login($user);
            $responsePayload = new UserResource(
                resource: $user,
                accessToken: $token
            );

            DB::commit();

            $user->notify(new AccountRegisteredNotification($request->password));

            return HttpResponse::success(
                data: $responsePayload,
                httpCode: JsonResponse::HTTP_CREATED
            );

        } catch (\Throwable $th) {
            DB::rollBack();
            return HttpResponse::error(
                data: "Failed to create account: {$th->getMessage()}",
            );
        }

    }
}
