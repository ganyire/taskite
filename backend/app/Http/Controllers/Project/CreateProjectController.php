<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Services\HttpResponse;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;

class CreateProjectController extends Controller
{
    /**
     * Handle the incoming request.
     * ------------
     */
    public function __invoke(CreateProjectRequest $request): JsonResponse
    {
        /**
         * @var \App\Models\User $user
         */
        $user = $request->user();
        $team = $request->whenFilled('team',
            fn() => TeamService::getTeamByUniqueKeys($request->team)
        );
        /**
         * @var \App\Models\Project $project
         */
        $project = $user->projects()->create([
            'name' => $request->name,
            'description' => $request->description,
            'team_id' => $team?->id,
        ]);
        $project->load('user', 'team');
        $project->refresh();
        $responsePayload = new ProjectResource($project);

        return HttpResponse::success(
            message: __('project.created'),
            data: $responsePayload,
            httpCode: JsonResponse::HTTP_CREATED
        );
    }
}
