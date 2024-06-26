<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\Common\DateResource;
use App\Http\Resources\Team\TeamResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
     * ----------
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->whenNotNull($this->description),
            'status' => $this->status,
            'team' => $this->whenLoaded(
                'team',
                new TeamResource($this->team, false)
            ),
            'owner' => new UserResource(
                $this->whenLoaded('user'),
                false
            ),
            $this->mergeWhen($this->showTimestamps, [
                'createdAt' => new DateResource($this->created_at),
                'updatedAt' => new DateResource($this->updated_at),
            ]),
        ];

    }
}
