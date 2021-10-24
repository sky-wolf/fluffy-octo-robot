<?php

namespace app\Database\Migration\Field;

use app\Database\Exception\MigrationException;

class TextField extends Field
{
    public ?string $default = null;

    public function nullable(): static
    {
        throw new MigrationException('Text fields cannot be nullable');
    }

    public function default(string $value): static
    {
        $this->default = $value;
        return $this;
    }
}