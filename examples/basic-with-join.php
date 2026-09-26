<?php

use RotyQuery\ModelBase;


require __DIR__."/../vendor/autoload.php";

$query = new ModelBase();
$query->q_setTable("user");
$query->q_select();
$query->q_join("courses", "courses.id", "user.courseId");
$query->q_where('role', 'user');

print_r($query->q_builder()); // SELECT * FROM user WHERE role = 'user'
