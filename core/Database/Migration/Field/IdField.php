<?php

namespace Framework\Database\Migration\Field;

class IdField extends Field
{
    public ?float $default = null;

    public function default(float $value):static
    {
        echo 'ID field cannot have a default value';
    }
}