<?php

use RotyQuery\ModelBase;

require __DIR__."/../vendor/autoload.php";

$query = new ModelBase();
$query->q_setTable("user");

$query->q_insert([
    "id"=>1,
    "user"=>"silvaleal"
]);

print_r($query);