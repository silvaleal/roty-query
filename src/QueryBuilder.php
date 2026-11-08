<?php

namespace RotyQuery;

use Exception;

abstract class QueryBuilder
{
    use QueryOperator;
    use QueryConsulter;

    protected string $query = '';
    protected string $type = '';
    public array $data = [];
    public array $wheres = [];
    protected array $joins = [];
    protected ?string $order;
    protected ?int $limit;
    protected string $table;
    protected string $columns = '*';

    public function q_builder()
    {
        $query = $this->query;

        if (!$this->table) {
            throw new Exception("Table not inserted");
        }

        $query = $this->join_builder($query);
        $query = $this->where_builder($query);
        $query = $this->order_builder($query);
        $query = $this->limit_builder($query);


        return $query;
    }

    private function join_builder(string $query)
    {
        if (!empty($this->joins)) {
            $joins = [];

            foreach ($this->joins as $key => $value) {
                $joins[] = $value;
            }

            $query .= " " . implode(' ', $joins);
        }
        return $query;

    }

    private function where_builder(string $query)
    {
        if (empty($this->wheres)) {
            return $query;
        }

        foreach ($this->wheres as $value) {

            $type = $value['type'];
            $sql = $value['query'];

            switch ($type) {
                case 'normal':
                    $parts = explode(' ', $sql);

                    $column = $parts[0];
                    $symbol = $parts[1];
                    $value = $parts[2];

                    $wheres[] = "{$column} {$symbol} {$value}";
                    break;

                case 'where_in':
                    $wheres[] = $sql;
                    break;

                case 'is_null':
                    $wheres[] = "$sql";
                    break;

                default:
                    throw new Exception("Invalid where type: $type");
            }

        }
        
        if (stripos($query, ' WHERE ') === false) {
            $query .= ' WHERE ' . implode(' AND ', $wheres);
        } else {
            $query .= ' AND ' . implode(' AND ', $wheres);
        }

        return $query;
    }

    private function order_builder(string $query)
    {
        if (isset($this->order)) {
            $query .= " ORDER BY $this->order";
        }
        return $query;
    }
    private function limit_builder(string $query)
    {
        if (isset($this->limit)) {
            $query .= " LIMIT $this->limit";
        }
        return $query;
    }

}
