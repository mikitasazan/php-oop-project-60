# Валидатор данных (PHP)

[![hexlet-check](https://github.com/mikitasazan/php-oop-project-60/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/mikitasazan/php-oop-project-60/actions)

Создание собственной библиотеки для проверки корректности (валидации) данных – отличный способ прокачать навыки проектирования кода, в особенности, объектно-ориентированной архитектуры. Создание правильных иерархий классов, глубокая работа с $this, расширяемая архитектура, применение принципов SOLID, использование fluent-интерфейса – все это предстоит делать в проекте

Учебный проект Хекслета: https://ru.hexlet.io/programs/php-oop
Как это должно работать: https://asciinema.org/a/a96Smlw7w7KD3b4OxC1WeeDPT

## Стек

- PHP 8.3+
- PHPUnit — тесты
- PHP_CodeSniffer (PSR12), PHPStan — линтеры

## Установка

```bash
git clone https://github.com/mikitasazan/php-oop-project-60.git
cd php-oop-project-60
make install
```

## Использование

```php
<?php

use Hexlet\Validator\Validator;

require 'vendor/autoload.php';

$v = new Validator();

$schema = $v->string()->required()->minLength(10);
$schema->isValid('what does the fox say'); // true
$schema->isValid('hexlet');                // false

$number = $v->number()->required()->positive();
$number->isValid(10);   // true
$number->isValid(-10);  // false

// собственный валидатор
$v->addValidator('string', 'startWith', fn($value, $start) => str_starts_with($value, $start));
$v->string()->test('startWith', 'H')->isValid('Hexlet'); // true
```

## Проверка локально

```bash
make lint   # phpcs (PSR12) + phpstan
make test   # PHPUnit
```

---

<details>
<summary>Автоматические тесты Хекслета</summary>

Тесты запускаются на каждый коммит. За запуск отвечает файл `.github/workflows/hexlet-check.yml` — не удаляйте и не переименовывайте ни его, ни репозиторий.

</details>

## О Хекслете

[Хекслет](https://ru.hexlet.io/) — школа программирования: авторские программы обучения с практикой, поддержкой наставников и реальными проектами, которые остаются в резюме. Этот репозиторий — один из таких проектов.
