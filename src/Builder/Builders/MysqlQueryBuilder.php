<?php

namespace Patterns\Builder\Builders;

use Patterns\Builder\Contracts\SQLQueryBuilder;

class MysqlQueryBuilder implements SQLQueryBuilder
{
    protected $query;

    protected function reset(): void
    {
        $this->query = new \stdClass();
    }

    public function select(string $table, array $fields): SQLQueryBuilder
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        $this->query->type = "select";

        return $this;
    }

    public function where(string $field, string $value, string $operator = '='): SQLQueryBuilder
    {
        if(! in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("Where can only be added to SELECT, UPDATE or DELETE types.");
        }

        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    public function limit(int $start, int $offset): SQLQueryBuilder
    {
        if(! in_array($this->query->type, ['select'])) {
            throw new \Exception("Limit can only be added to SELECT type.");
        }

        $this->query->limit = "LIMIT " . $start . ", " . $offset;

        return $this;
    }

    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if (! empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }

        if (isset($query->limit)) {
            $sql .= " " . $query->limit;
        }

        $sql .= ";";
        return $sql;
    }
}
