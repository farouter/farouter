<?php

namespace Farouter\Http\Controllers;

use Farouter\Http\Resources\NodeResource;
use Farouter\Models\Node;
use Inertia\Inertia;

class NodeController extends Controller
{
    public function show(Node $node)
    {
        return Inertia::render('Node/Show', [
            'node' => new NodeResource($node),
        ]);
    }
}
