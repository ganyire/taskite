<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Common\DateResource;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Team\TeamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param bool $showTimestamps
     */
    public function __construct(
        public $resource,
        private $accessToken,
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
        $teamRole = $this->getCurrentTeamRole($this->ownedTeam?->id);

        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'team'        => new TeamResource($this->ownedTeam, false),
            'accessToken' => $this->accessToken,
            'teamRole'    => new RoleResource($teamRole, false),
            $this->mergeWhen($this->showTimestamps, [
                'createdAt' => new DateResource($this->created_at),
                'updatedAt' => new DateResource($this->updated_at),
            ]),
        ];

    }
}
