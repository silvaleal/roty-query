<?php

use RotyQuery\QueryBuilder;

require __DIR__ . "/../vendor/autoload.php";

class User extends QueryBuilder
{
    protected string $table = "user";
}

$user = new User();

$user->q_select();
$user->q_join("courses", "courses.id", "user.courseId");
$user->q_where('role', 'user');

print_r($user->q_builder()); // SELECT * FROM user JOIN courses ON courses.id = user.courseId WHERE role = :role
