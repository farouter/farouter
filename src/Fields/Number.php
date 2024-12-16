<?php

namespace Farouter\Fields;

/**
 * Class Number
 *
 * Represents a numeric field with additional constraints such as min, max, and step values.
 *
 * @property string $component The identifier for the field's frontend component.
 * @property mixed $min The minimum value allowed for the number field.
 * @property mixed $max The maximum value allowed for the number field.
 * @property mixed $step The increment step for the number field.
 */
class Number extends Field
{
    /**
     * The field's component identifier for rendering.
     */
    public string $component = 'number-field';

    /**
     * The minimum value allowed for the number field.
     */
    public mixed $min;

    /**
     * The maximum value allowed for the number field.
     */
    public mixed $max;

    /**
     * The increment step for the number field.
     */
    public mixed $step;

    /**
     * Set the minimum value for the number field.
     *
     * @param  mixed  $min  The minimum value.
     * @return $this
     */
    public function min(mixed $min): self
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Set the maximum value for the number field.
     *
     * @param  mixed  $max  The maximum value.
     * @return $this
     */
    public function max(mixed $max): self
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Set the increment step for the number field.
     *
     * @param  mixed  $step  The step value.
     * @return $this
     */
    public function step(mixed $step): self
    {
        $this->step = $step;

        return $this;
    }
}
