<?php

use RotyQuery\ModelBuilder;

require __DIR__."/../src/ModelBuilder.php";

$query = new ModelBuilder();
$query->q_setTable("user");
$query->q_select();
$query->q_limit(10);
$query->q_where('role', 'user');

print_r($query->q_builder()); // SELECT * FROM user WHERE role = 'user'
