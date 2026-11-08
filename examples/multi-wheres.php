<?php

use RotyQuery\QueryBuilder;

require __DIR__ . "/../vendor/autoload.php";

class User extends QueryBuilder
{
    protected string $table = "user";
}

$user = new User();

$user->q_select();
$user->q_where("id", 2);
$user->q_where("role", "admin");

print_r($user->q_builder()); // SELECT * FROM user WHERE id = :id AND role = :role
