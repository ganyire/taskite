<?php

namespace App\Http\Resources\Tasks;

use App\Http\Resources\Common\DateResource;
use App\Http\Resources\Common\EnumResource;
use App\Http\Resources\Project\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->whenNotNull('description'),
            'status' => new EnumResource($this->whenNotNull($this->status)),
            'project' => new ProjectResource(
                $this->whenLoaded('project'),
                false
            ),
            'reasonForCancellation' => $this->whenNotNull($this->reasonForCancellation),
            'dueDate' => new DateResource($this->whenNotNull($this->due_date)),
            $this->mergeWhen($this->showTimestamps, [
                'createdAt' => new DateResource($this->created_at),
                'updatedAt' => new DateResource($this->updated_at),
            ]),
        ];

    }
}
