<?php

namespace App\Dto\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RegisterDto
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $email,
        public readonly string $name,
        public readonly string $password,
        public readonly string $teamName,

    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            email: $request->email,
            name: $request->name,
            password: $request->password,
            teamName: $request->teamName,
        );
    }

    public function toArray(?bool $filter = true): array
    {
        $data = [
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
            'teamName' => $this->teamName,
        ];

        return $filter ? Arr::where(
            $data,
            fn($value) => !empty($value) && !is_null($value)
        ) : $data;
    }
}
