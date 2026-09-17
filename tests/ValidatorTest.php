<?php

declare(strict_types=1);

namespace Hexlet\Validator\Tests;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testString(): void
    {
        $v = new Validator();
        $schema = $v->string();

        // Без required пустая строка и null валидны
        $this->assertTrue($schema->isValid(''));
        $this->assertTrue($schema->isValid(null));
        $this->assertTrue($schema->isValid('hexlet'));

        $schema->required();

        $this->assertTrue($schema->isValid('what does the fox say'));
        $this->assertTrue($schema->isValid('hexlet'));
        $this->assertFalse($schema->isValid(null));
        $this->assertFalse($schema->isValid(''));
    }

    public function testStringContains(): void
    {
        $v = new Validator();

        $this->assertTrue($v->string()->contains('what')->isValid('what does the fox say'));
        $this->assertFalse($v->string()->contains('whatthe')->isValid('what does the fox say'));
    }

    public function testStringMinLengthLastCallWins(): void
    {
        $v = new Validator();

        $this->assertFalse($v->string()->minLength(10)->isValid('hexlet'));
        $this->assertTrue($v->string()->minLength(10)->minLength(4)->isValid('hexlet'));
    }

    public function testSchemasAreIndependent(): void
    {
        $v = new Validator();
        $first = $v->string();
        $first->required();

        $this->assertTrue($v->string()->isValid(''));
        $this->assertFalse($first->isValid(''));
    }

    public function testNumber(): void
    {
        $v = new Validator();
        $schema = $v->number();

        // Без required null валиден, даже при positive()
        $this->assertTrue($schema->isValid(null));
        $this->assertTrue($schema->isValid(5));
        $this->assertTrue($schema->positive()->isValid(null));

        $schema->required();

        $this->assertFalse($schema->isValid(null));
        $this->assertFalse($schema->isValid(-10));
        $this->assertFalse($schema->isValid(0));
        $this->assertTrue($schema->isValid(10));
    }

    public function testNumberRange(): void
    {
        $v = new Validator();
        $schema = $v->number()->required()->positive();
        $schema->range(-5, 5);

        // -3 попадает в диапазон, но не положительно
        $this->assertFalse($schema->isValid(-3));
        $this->assertTrue($schema->isValid(5));
        $this->assertFalse($schema->isValid(6));
    }
}
