<?php

namespace Farouter\Fields;

class ID extends Field
{
    /**
     * The field's component.
     */
    public string $component = 'id-field';

    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name ?? 'ID', $attribute);
    }
}
