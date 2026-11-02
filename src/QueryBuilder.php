<?php

namespace RotyQuery;

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
                if ($key == 'where_in') {
                    $wheres[] = "$value";
                    continue;
                }

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
}
