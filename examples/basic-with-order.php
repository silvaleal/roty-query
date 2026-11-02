<?php

use RotyQuery\QueryBuilder;

require __DIR__ . "/../vendor/autoload.php";

class User extends QueryBuilder
{
    protected ?string $table = "user";
}

$user = new User();

$user->q_select();
$user->q_order("id");

print_r($user->q_builder()); // SELECT * FROM user ORDER BY id DESC
