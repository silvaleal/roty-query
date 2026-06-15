<?php

use RotyQuery\ModelBuilder;

require __DIR__."/../src/ModelBuilder.php";

$query = new ModelBuilder();
$query->q_setTable("user");
$query->q_select();
$query->q_order("id");

print_r($query->q_builder()); // SELECT * FROM user WHERE role = 'user'
