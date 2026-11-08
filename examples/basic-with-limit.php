<?php

use RotyQuery\QueryBuilder;

require __DIR__ . "/../vendor/autoload.php";

class User extends QueryBuilder
{
    protected string $table = "user";
}

$user = new User();

$user->q_select();
$user->q_limit(10);
$user->q_where('role', 'user');

print_r($user->q_builder()); // SELECT * FROM user WHERE role = :role LIMIT 10
