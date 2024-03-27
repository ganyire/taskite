<?php

namespace App\Http\Resources\Role;

use App\Http\Resources\Common\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Flag to determine whether to show timestamps or not
     *
     * @var string
     */
    private bool $showTimestamps;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param bool $showTimestamps
     */
    public function __construct($resource, $showTimestamps = true)
    {
        parent::__construct($resource);
        $this->showTimestamps = $showTimestamps;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'displayName' => $this->display_name,
            $this->mergeWhen($this->showTimestamps, [
                'createdAt' => new DateResource($this->created_at),
                'updatedAt' => new DateResource($this->updated_at),
            ]),
        ];

    }
}
