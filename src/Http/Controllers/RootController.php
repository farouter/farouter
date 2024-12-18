<?php

namespace Farouter\Http\Controllers;

use Farouter\Models\Node;

class RootController
{
    public function __invoke()
    {
        $node = Node::root()->first();

        return redirect()->route('farouter::nodes.edit', ['node' => $node]);
    }
}
