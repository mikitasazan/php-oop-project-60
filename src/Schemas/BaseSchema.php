<?php

declare(strict_types=1);

namespace Hexlet\Validator\Schemas;

/**
 * Базовая схема: хранит именованные проверки и решает, валидно ли значение.
 * Повторный вызов одной проверки заменяет её аргументы, а не дублирует.
 */
class BaseSchema
{
    /** @var array<string, array{validate: callable, arguments: array<array-key, mixed>}> */
    protected array $checks = [];

    /** @var array<string, callable> */
    protected array $validators = [];

    protected bool $required = false;

    /**
     * @param array<string, callable> $validators
     */
    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    /**
     * @param mixed ...$arguments аргументы, с которыми зарегистрирована проверка
     */
    public function test(string $name, mixed ...$arguments): static
    {
        $this->addCheck($name, ...$arguments);
        return $this;
    }

    public function required(): static
    {
        $this->required = true;
        $this->addCheck('required');
        return $this;
    }

    public function addCheck(string $name, mixed ...$arguments): void
    {
        $this->checks[$name] = [
            'validate' => $this->validators[$name],
            'arguments' => $arguments,
        ];
    }

    /**
     * Незаданное значение (не прошедшее required-проверку) валидно, пока
     * required() не вызван явно; остальные проверки к нему не применяются.
     */
    public function isValid(mixed $value): bool
    {
        if (!$this->required) {
            $isRequiredValid = ($this->validators['required'])($value);
            if (!$isRequiredValid) {
                return true;
            }
        }

        foreach ($this->checks as ['validate' => $validate, 'arguments' => $arguments]) {
            if (!$validate($value, ...$arguments)) {
                return false;
            }
        }

        return true;
    }
}
