<?php

use RotyQuery\QueryBuilder;

require __DIR__."/../src/QueryBuilder.php";

$query = new QueryBuilder();
$query->q_setTable("user");
$query->q_select();
$query->q_join("courses", "courses.id", "user.courseId");
$query->q_where('role', 'user');

print_r($query->q_builder()); // SELECT * FROM user WHERE role = 'user'
