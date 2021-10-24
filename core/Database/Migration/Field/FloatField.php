<?php

namespace Framwork\Database\Migration\Field;

class FloatField extends Field
{
    public ?float $default = null;

    public function default(float $value):static
    {
        $this->default = $value;
        return $this;
    }
}