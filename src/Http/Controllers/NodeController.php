<?php

namespace Farouter\Http\Controllers;

use Farouter\Http\Requests\FarouterRequest;
use Farouter\Http\Requests\NodeableStoreRequest;
use Farouter\Http\Requests\NodeableUpdateRequest;
use Farouter\Http\Resources\NodeResource;
use Farouter\Models\Node;
use Inertia\Inertia;

class NodeController
{
    public function create(Node $node, string $nodeableType, FarouterRequest $request)
    {
        $resource = new $nodeableType($request);

        return Inertia::render('Node/Create', [
            'node' => new NodeResource($node),
            'resource' => $resource,
            'nodeableType' => $nodeableType,
        ]);
    }

    public function store(Node $node, string $nodeableType, NodeableStoreRequest $request)
    {
        $nodeable = $nodeableType::$model::create([
            ...$request->validated(),
            'parentNode' => $node,
        ]);

        return redirect()->route('farouter::nodes.edit', ['node' => $nodeable->node]);
    }

    public function edit(Node $node)
    {
        $children = $node->children()->paginate();

        return Inertia::render('Node/Edit', [
            'node' => new NodeResource($node),
            'children' => NodeResource::collection($children),
        ]);
    }

    public function update(Node $node, NodeableUpdateRequest $request)
    {
        $node->nodeable->update($request->all());

        return redirect()
            ->route('farouter::nodes.edit', ['node' => $node])
            ->with('success', 'Node updated');
    }

    public function delete(Node $node)
    {
        $node->delete();

        //
    }
}
