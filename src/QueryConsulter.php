<?php

namespace RotyQuery;

use Exception;
use InvalidArgumentException;

trait QueryConsulter
{
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

    public function q_where(string $column, int|string|array|null $value, string $symbol = "=")
    {
        if ($value === null) {
            $operador = match ($symbol) {
                "=" => "IS",
                "!=" => "IS NOT",
                default => throw new InvalidArgumentException(
                    "Invalid operator for NULL value."
                )
            };

            $this->wheres[$column] = "$column $operador NULL";
            return $this;

        } elseif (is_array($value)) {
            foreach ($value as $key) {
                $data[":$column" . "_$key"] = $key;
            }

            $this->wheres["where_in"] = "$column IN " . "(" . implode(', ', array_keys($data)) . ")";

            foreach ($data as $key => $value) {
                $this->data["wheres"][$key] = $value;
            }

            return $this;
        }

        $parameter = str_replace(".", "_", $column);

        $this->wheres[$column] = "$column $symbol :$parameter";
        $this->data["wheres"][$parameter] = $value;

        return $this;
    }
}
