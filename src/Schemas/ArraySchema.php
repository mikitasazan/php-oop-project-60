<?php

declare(strict_types=1);

namespace Hexlet\Validator\Schemas;

class ArraySchema extends BaseSchema
{
    /**
     * Проверяет каждый элемент массива своей схемой. Ключи без схем
     * и схемы для отсутствующих ключей не рассматриваются: свою работу
     * делает вложенная схема (в том числе для null).
     *
     * @param array<string, BaseSchema> $schemas
     */
    public function shape(array $schemas): static
    {
        $check = static function (array $value) use ($schemas): bool {
            foreach ($schemas as $key => $schema) {
                if (!$schema->isValid($value[$key] ?? null)) {
                    return false;
                }
            }
            return true;
        };
        $this->addCheck('shape', $check);
        return $this;
    }

    public function sizeof(int $size): static
    {
        $this->addCheck('sizeof', $size);
        return $this;
    }
}
