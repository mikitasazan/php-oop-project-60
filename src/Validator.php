<?php

declare(strict_types=1);

namespace Hexlet\Validator;

/**
 * Фабрика схем валидации. Набор встроенных проверок каждой схемы задаётся
 * здесь и расширяется извне через addValidator().
 */
class Validator
{
    /** @var array<string, array<string, callable>> */
    private array $validatorsPerSchema = [];

    public function __construct()
    {
        $this->validatorsPerSchema = [
            'string' => [
                'required' => static fn(mixed $value): bool => is_string($value) && $value !== '',
                'contains' => static fn(string $value, string $substring): bool => str_contains($value, $substring),
                'minLength' => static fn(string $value, int $length): bool => strlen($value) >= $length,
            ],
        ];
    }

    public function string(): Schemas\StringSchema
    {
        return new Schemas\StringSchema($this->validatorsPerSchema['string']);
    }

    /**
     * Регистрирует пользовательскую проверку для типа схемы. Доступна в схеме
     * через test($name, ...$arguments).
     */
    public function addValidator(string $schema, string $name, callable $fn): void
    {
        $this->validatorsPerSchema[$schema][$name] = $fn;
    }
}
