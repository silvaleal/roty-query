<?php

use RotyQuery\QueryBuilder;

require __DIR__ . "/../vendor/autoload.php";

class User extends QueryBuilder
{
    protected ?string $table = "user";
}

$user = new User();
    
$user->q_insert([
    "id" => 1,
    "user" => "silvaleal",
]);

print_r($user->q_builder());
