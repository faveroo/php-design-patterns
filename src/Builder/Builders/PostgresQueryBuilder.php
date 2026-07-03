<?php

namespace Patterns\Builder\Builders;

use Patterns\Builder\Contracts\SQLQueryBuilder;

class PostgresQueryBuilder extends MysqlQueryBuilder
{
    public function limit(int $start, int $offset): SQLQueryBuilder
    {
        parent::limit($start, $offset);
        
        $this->query->limit = "LIMIT " . $start . " OFFSET " . $offset;

        return $this;
    }
}