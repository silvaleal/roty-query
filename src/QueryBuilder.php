<?php

namespace RotyQuery;

use Exception;

trait QueryBuilder
{
    protected string $query = '';
    protected string $type = '';
    public array $data = [];
    public array $wheres = [];
    protected array $joins = [];
    protected ?string $order;
    protected ?int $limit;
    protected ?string $table;
    protected string $columns = '*';

    public function q_builder()
    {       
        $query = $this->query;

        if (!empty($this->joins)) {
            $joins = [];

            foreach ($this->joins as $key => $value) {
                $joins[] = $value;
            }

            $query .= " " . implode(' ', $joins);
        }

        if (!empty($this->wheres)) {
            $wheres = [];
            foreach ($this->wheres as $key => $value) {
                $parts = explode(' ', $value);

                $column = $parts[0];
                $symbol = $parts[1];
                $value = $parts[2];

                $wheres[] = "{$column} {$symbol} {$value}";
            }

            if (stripos($query, ' WHERE ') === false) {
                $query .= ' WHERE ' . implode(' AND ', $wheres);
            } else {
                $query .= ' AND ' . implode(' AND ', $wheres);
            }
        }

        if (isset($this->order)) {
            $query .= " ORDER BY $this->order";
        }

        if (isset($this->limit)) {
            $query .= " LIMIT $this->limit";
        }

        return $query;
    }

    public function q_select(string $columns = '*')
    {
        $this->columns = $columns;
        $this->type = "select";
        $this->query = "SELECT {$this->columns} FROM {$this->table}";
        return $this;
    }

    public function q_join(string $table, string $key, string $field)
    {
        $this->joins[] = "JOIN {$table} ON {$key} = {$field}";
        return $this;
    }

    public function q_order(string $column, string $order = "DESC")
    {
        $this->order = "$column $order";
        return $this;
    }

    public function q_limit(int $num)
    {
        if ($num <= 0) {
            throw new Exception("Invalid limit. ($num)");
        }

        $this->limit = $num;
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
            $results[":{$key}"] = $value;
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
            $results[":{$key}"] = $value;
        }

        $this->type = "update";
        $this->query = "UPDATE {$this->table} SET " . implode(',', $setters);
        $this->data['updaters'] = $results;
        return $this;
    }

    public function q_del(array $data)
    {
        $columns = [];
        $values = [];
        $results = [];

        foreach ($data as $key => $value) {
            $columns[] = $key;
            $values[] = ":{$key}";
            $results[":{$key}"] = $value;
        }
        $columns = implode(",", $columns);
        $values = implode(",", $values);

        $this->type = "delete";
        $this->query = "DELETE FROM {$this->table} WHERE {$columns} = {$values}";
        $this->data["deletories"] = $results;
        return $this;
    }

    public function q_where(string $column, int|string $value, string $symbol = "=", )
    {
        $this->wheres[$column] = "$column $symbol :". str_replace(".", "_", $column);

        $this->data["wheres"][str_replace(".", "_", $column)] = $value;

        return $this;
    }
}