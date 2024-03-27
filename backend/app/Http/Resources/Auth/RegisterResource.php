<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Common\DateResource;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Team\TeamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * @var bool $showTimestamps
     */
    private bool $showTimestamps;

    /**
     * @var string $accessToken
     */
    private string $accessToken;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param string $accessToken
     * @param bool $accessToken
     */
    public function __construct($resource, string $accessToken, bool $showTimestamps = true)
    {
        parent::__construct($resource);
        $this->accessToken    = $accessToken;
        $this->showTimestamps = $showTimestamps;
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
            'id'              => $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'ownedTeam'       => new TeamResource($this->ownedTeam, false),
            'accessToken'     => $this->accessToken,
            'currentTeamRole' => new RoleResource($teamRole, false),
            $this->mergeWhen($this->showTimestamps, [
                'createdAt' => new DateResource($this->created_at),
                'updatedAt' => new DateResource($this->updated_at),
            ]),
        ];
    }
}
