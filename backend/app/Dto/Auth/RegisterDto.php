<?php

namespace App\Dto\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

readonly class RegisterDto
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $email,
        public string $name,
        public string $password,
        public string $teamName,
        public ?string $teamDisplayName = null,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            email: $request->email,
            name: $request->name,
            password: $request->password,
            teamName: $request->teamName,
            teamDisplayName: $request->teamDisplayName,
        );
    }

    public function toArray(?bool $filter = true): array
    {
        $data = [
            'name'            => $this->name,
            'email'           => $this->email,
            'password'        => $this->password,
            'teamName'        => $this->teamName,
            'teamDisplayName' => $this->teamDisplayName,
        ];

        return $filter ? Arr::where(
            $data,
            fn($value) => !empty($value)
        ) : $data;
    }
}
