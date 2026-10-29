<?php

use RotyQuery\ModelBase;

require __DIR__."/../vendor/autoload.php";

$query = new ModelBase();
$query->q_setTable("user");
$query->q_select();
$query->q_where("id", 2);
$query->q_where("role", "admin");

print_r($query->q_builder());
