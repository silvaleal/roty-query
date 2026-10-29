<?php

use RotyQuery\ModelBase;

require __DIR__."/../vendor/autoload.php";

$query = new ModelBase();
$query->q_setTable("user");
$query->q_select();
$query->q_where("id", 2);
// $query->q_where("id", "2'OR'1'='1");

// print_r($query->q_builder()); // SELECT * FROM user WHERE clan = 'AAA' AND regionAge > 1 AND regionName LIKE '%A%'
print_r($query);
print_r($query->q_builder());
