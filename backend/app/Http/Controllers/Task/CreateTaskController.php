<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Resources\Tasks\TaskResource;
use App\Models\Task;
use App\Services\HttpResponse;
use Illuminate\Http\JsonResponse;

class CreateTaskController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateTaskRequest $request): JsonResponse
    {
        $task = Task::query()->create($request->validated());
        $task->loadMissing(['project']);
        $task->refresh();
        $responsePayload = new TaskResource($task);
        return HttpResponse::success(
            message: __('task.created'),
            data: $responsePayload,
            httpCode: JsonResponse::HTTP_CREATED,
        );
    }
}
