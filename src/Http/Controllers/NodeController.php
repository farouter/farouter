<?php

namespace Farouter\Http\Controllers;

use App\Farouter\Resources\Root;
use Farouter\Http\Requests\FarouterRequest;
use Farouter\Models\Node;

class NodeController
{
    public function create(Node $parentNode, string $nodeable)
    {
        //
    }

    public function store(Node $parentNode)
    {
        //
    }

    public function show(Node $node, FarouterRequest $request)
    {
        $rootResource = new Root($node->nodeable);

        // foreach ($rootResource->fields($request) as &$field) {
        //     $field->resolve($node->nodeable);
        // }

        dd(json_encode($rootResource));
    }

    public function update(Node $node)
    {
        //
    }

    public function delete(Node $node)
    {
        $node->delete();

        //
    }
}
