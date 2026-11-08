<?php

namespace RotyQuery;

use Exception;

trait QueryOperator
{
    public function q_select(string $columns = '*')
    {

        if (!$this->table) {
            throw new Exception("Table not insered");
        }

        $this->columns = $columns;
        $this->type = "select";
        $this->query = "SELECT {$this->columns} FROM {$this->table}";
        return $this;
    }

    public function q_insert(array $data)
    {
        $columns = [];
        $values = [];
        $results = [];

        foreach ($data as $key => $value) {
            $columns[] = $key;
            $values[] = ":{$key}";
            $results["{$key}"] = $value;
        }
        $columns = implode(",", $columns);
        $values = implode(",", $values);

        $this->type = "insert";
        $this->query = "INSERT INTO {$this->table} (" . $columns . ") VALUES (" . $values . ")";
        $this->data["inserters"] = $results;
        return $this;
    }

    public function q_update(array $data)
    {
        $setters = [];
        $results = [];

        foreach ($data as $key => $value) {
            $setters[] = "{$key} = :{$key}";
            $results["{$key}"] = $value;
        }

        $this->type = "update";
        $this->query = "UPDATE {$this->table} SET " . implode(',', $setters);
        $this->data['updaters'] = $results;
        return $this;
    }

    public function q_del()
    {
        
        $this->type = "delete";
        $this->query = "DELETE FROM {$this->table}";
        // $this->data["deletories"] = $results;
        return $this;
    }
}
