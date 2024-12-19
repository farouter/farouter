<?php

namespace Farouter\Http\Resources;

use Farouter\Farouter;
use Farouter\Http\Requests\FarouterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resolvedResource = Farouter::resolveResourceForModel($this->nodeable);

        $resource = new $resolvedResource(resolve(FarouterRequest::class), $this->nodeable);

        return [
            'id' => $this->id,
            'nodeable_type' => $this->nodeable_type,
            'nodeable_id' => $this->nodeable_id,
            'resource' => $resource,
            'children' => self::collection($this->whenLoaded('children')),
        ];
    }
}
