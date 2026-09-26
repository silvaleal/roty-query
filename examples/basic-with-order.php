<?php

use RotyQuery\ModelBase;

require __DIR__."/../vendor/autoload.php";

$query = new ModelBase();
$query->q_setTable("user");
$query->q_select();
$query->q_order("id");

print_r($query->q_builder()); // SELECT * FROM user ORDER BY id DESC
