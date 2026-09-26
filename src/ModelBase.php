<?php

namespace RotyQuery;


use RotyQuery\QueryBuilder;

class ModelBase
{
    use QueryBuilder;

    public function q_getQuery()
    {
        return $this->query;
    }

    public function q_setTable($table)
    {
        $this->table = $table;
    }
}
