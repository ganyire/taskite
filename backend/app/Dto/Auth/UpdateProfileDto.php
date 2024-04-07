<?php

namespace App\Dto\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

readonly class UpdateProfileDto
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?string $name = null,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->name,
        );
    }

    public function toArray(?bool $filter = true): array
    {
        $data = [
            'name' => $this->name,
        ];
        return $filter ? Arr::where(
            $data,
            fn($value) => !empty($value)
        ) : $data;
    }

}
