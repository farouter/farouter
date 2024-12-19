<?php

namespace Farouter\Traits;

use Illuminate\Support\Str;
use InvalidArgumentException;

trait LocaleHelper
{
    /**
     * Convert a string to an Enum case.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public static function fromString(string $value): self
    {
        $value = Str::upper($value);

        $cases = array_column(self::cases(), 'name', 'value');

        if (! in_array($value, $cases)) {
            throw new InvalidArgumentException("Invalid enum string: {$value}");
        }

        return self::from(array_search($value, $cases, true));
    }

    /**
     * Convert an Enum case to its string representation.
     *
     * @throws \InvalidArgumentException
     */
    public function toString(): string
    {
        $cases = array_column(self::cases(), 'name', 'value');

        if (! isset($cases[$this->value])) {
            throw new InvalidArgumentException("Invalid enum value: {$this->value}");
        }

        return $cases[$this->value];
    }
}
