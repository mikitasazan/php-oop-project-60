<?php

declare(strict_types=1);

namespace Hexlet\Validator\Schemas;

class NumberSchema extends BaseSchema
{
    public function positive(): static
    {
        $this->addCheck('positive');
        return $this;
    }

    public function range(int|float $min, int|float $max): static
    {
        $this->addCheck('range', $min, $max);
        return $this;
    }
}
