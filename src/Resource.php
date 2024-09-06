<?php

namespace Farouter;

use Farouter\Http\Requests\FarouterRequest;
use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

abstract class Resource implements JsonSerializable
{
    public function __construct(
        public Model $resource,
    ) {}

    public function fields(FarouterRequest $request): array
    {
        return [];
    }

    /**
     * Prepare the field for JSON serialization.
     */
    public function jsonSerialize(): array
    {
        return [
            'resource' => $this->resource,
            'fields' => $this->fields(resolve(FarouterRequest::class)),
        ];
    }
}
