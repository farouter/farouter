<?php

namespace Farouter;

trait Makeable
{
    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }
}
