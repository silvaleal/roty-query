<?php

namespace RotyQuery;

use Exception;
use InvalidArgumentException;

trait QueryConsulter
{
    public function q_join(string $table, string $key, string $field)
    {

        if ($this->type != "select") {
            throw new Exception("$this->type not have support to join's");
        }

        $this->joins[] = "JOIN {$table} ON {$key} = {$field}";
        return $this;
    }

    public function q_order(string $column, string $order = "DESC")
    {
        if ($this->type != "select") {
            throw new Exception("$this->type not have support to order's");
        }

        $this->order = "$column $order";
        return $this;
    }

    public function q_limit(int $num)
    {
        if ($this->type != "select") {
            throw new Exception("$this->type not have support to order's");
        }

        if ($num <= 0) {
            throw new Exception("Invalid limit. ($num)");
        }

        $this->limit = $num;
        return $this;
    }

    public function q_where(string $column, int|string|array|null $value, string $symbol = "=")
    {
        $parameter = str_replace(".", "_", $column);

        $this->wheres[$column] = ["type" => "normal", "query" => "$column $symbol :$parameter"];
        $this->data["wheres"][$parameter] = $value;

        return $this;
    }

    public function q_where_null(string $column, string $symbol = "=")
    {
        $operador = match ($symbol) {
            "=" => "IS",
            "!=" => "IS NOT",
            default => throw new InvalidArgumentException(
                "Invalid operator for NULL value."
            )
        };

        $this->wheres[$column] = ["type" => "is_null", "query" => "$column $operador NULL"];
        return $this;
    }


    public function q_where_in(string $column, array $value)
    {

        if (empty($value)) {
            return $this;
        }

        foreach ($value as $key) {
            $data[":$column" . "_$key"] = $key;
        }

        $this->wheres["$column"] = ["type" => "where_in", "query" => "$column IN " . "(" . implode(', ', array_keys($data)) . ")"];

        foreach ($data as $key => $value) {
            $this->data["wheres"][$key] = $value;
        }

        return $this;
    }

}
