<?php

namespace App\Http\Resources\Todos;

use App\Http\Resources\Common\DateResource;
use App\Http\Resources\Tasks\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param bool $showTimestamps
     */
    public function __construct(
        public $resource,
        private bool $showTimestamps = true
    ) {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'isDone' => $this->done,
            'task' => new TaskResource(
                $this->whenLoaded('task'),
                false
            ),
            $this->mergeWhen($this->showTimestamps, [
                'createdAt' => new DateResource($this->created_at),
                'updatedAt' => new DateResource($this->updated_at),
            ]),
        ];

    }
}
