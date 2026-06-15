<?php

use RotyQuery\ModelBuilder;

require __DIR__."/../src/ModelBuilder.php";

$query = new ModelBuilder();
$query->q_setTable("user");
$query->q_select();
$query->q_where("clan", "AAA");
$query->q_where("regionAge", 1, ">");
$query->q_where("regionName", "%A%", "LIKE");

print_r($query->q_builder()); // SELECT * FROM user WHERE clan = 'AAA' AND regionAge > 1 AND regionName LIKE '%A%'
