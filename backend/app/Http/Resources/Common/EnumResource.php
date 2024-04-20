<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnumResource extends JsonResource
{
    /**
     * Create a new resource instance.
     * ------------
     */
    public function __construct(public $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     * ------------
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->value,
            'label' => $this->label(),
        ];
    }
}
