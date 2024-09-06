<?php

namespace Farouter\Http\Controllers;

use App\Farouter\Post;
use Farouter\Http\Resources\NodeResource;
use Farouter\Models\Node;
use Inertia\Inertia;

class NodeController extends Controller
{
    public function show(Node $node)
    {
        $node->load('nodal');

        $resource = new Post($node->nodal);

        return Inertia::render('Node/Show', [
            'node' => new NodeResource($node),
            'resource' => $resource,
        ]);
    }
}
