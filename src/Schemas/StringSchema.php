<?php

declare(strict_types=1);

namespace Hexlet\Validator\Schemas;

class StringSchema extends BaseSchema
{
    public function contains(string $substring): static
    {
        $this->addCheck('contains', $substring);
        return $this;
    }

    public function minLength(int $length): static
    {
        $this->addCheck('minLength', $length);
        return $this;
    }
}
