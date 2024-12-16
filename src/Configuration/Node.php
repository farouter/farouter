<?php

namespace Farouter\Configuration;

use Farouter\Models\Node as NodeModel;

abstract class Node
{
    public function __construct(
        public NodeModel $node,
    ) {}

    public function controller(): array
    {
        return [];
    }

    abstract public function dependencies(): array;
}
