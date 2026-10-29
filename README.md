# roty-query

A lightweight SQL Query Builder for PHP.

**roty-query** provides a simple, fluent API to build SQL queries without writing raw SQL by hand. It is part of [RotyPHP](https://rotyphp.silvaleal.dev), an ORM for PHP, and works as the query-building foundation behind it.

> ⚠️ This project is under active development. The API may change between releases.

## Requirements

- PHP 8.0 or higher
- [Composer](https://getcomposer.org/)

## Installation

```bash
composer require silvaleal/rotyquery
```

## Usage

```php
use RotyQuery\ModelBase;

require __DIR__ . '/vendor/autoload.php';

$query = new ModelBase();
$query->q_setTable("user");
$query->q_select();
$query->q_where('role', 'user');

echo $query->q_builder(); // SELECT * FROM user WHERE role = :role
```

## Examples

More complete examples are available in the [`examples`](./examples) directory:

- [Basic select](./examples/basic-with-join.php)
- [Ordering](./examples/basic-with-order.php)
- [Limiting](./examples/basic-with-limit.php)
- [Multiple where conditions](./examples/multi-wheres.php)
- [Insert](./examples/basic-create.php)

## Documentation

Learn how to use RotyPHP by reading our documentation by clicking [here](https://rotyphp.silvaleal.dev/docs/querybuilder/introduction).