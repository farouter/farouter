<?php

namespace Farouter\Http\Controllers;

use Farouter\Http\Requests\FarouterRequest;
use Farouter\Models\Node;
use Inertia\Inertia;

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
        return Inertia::render('Node/Edit');
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
