<?php

namespace RotyQuery;

use Exception;

trait QueryBuilder
{
    protected string $query = '';
    protected string $type = '';
    protected array $data = [];
    protected array $wheres = [];
    protected array $joins = [];
    protected ?string $order;
    protected ?int $limit;
    protected ?string $table;
    protected string $columns = '*';

    public function q_builder()
    {
        if (!empty($this->joins)) {
            $joins = [];

            foreach ($this->joins as $key => $value) {
                $joins[] = $value;
            }

            $this->query .= " " . implode(' ', $joins);

        }

        if (!empty($this->wheres)) {
            $wheres = [];
            foreach ($this->wheres as $key => $value) {
                $parts = explode(' ', $value);

                $column = $parts[0];
                $symbol = $parts[1];
                $value = $parts[2];

                $quoted = is_numeric($value) ? $value : "'" . (string) $value . "'";
                $wheres[] = "{$column} {$symbol} {$quoted}";
            }

            if (stripos($this->query, ' WHERE ') === false) {
                $this->query .= ' WHERE ' . implode(' AND ', $wheres);
            } else {
                $this->query .= ' AND ' . implode(' AND ', $wheres);
            }
        }

        if (isset($this->order)) {
            $this->query .= " ORDER BY $this->order";
        }

        if (isset($this->limit)) {
            $this->query .= " LIMIT $this->limit";
        }

        return $this->query;
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
        $this->wheres[$column] = "$column $symbol $value";
        return $this;
    }
}