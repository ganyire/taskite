<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Common\DateResource;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Team\TeamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param bool $showTimestamps
     */
    public function __construct(
        public $resource,
        private bool $showTimestamps = true,
        private string $accessToken = '',
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
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'team'        => new TeamResource($this->whenAppended('ownedTeam'), false),
            'accessToken' => $this->when($this->accessToken, $this->accessToken),
            'teamRole'    => $this->whenAppended('ownedTeam', new RoleResource(
                $this->getCurrentTeamRole($this->ownedTeam?->id),
                false
            )),
            $this->mergeWhen($this->showTimestamps, [
                'createdAt' => new DateResource($this->created_at),
                'updatedAt' => new DateResource($this->updated_at),
            ]),
        ];

    }
}
