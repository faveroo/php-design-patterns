<?php

namespace Patterns\Builder\Contracts;

interface SQLQueryBuilder
{
    public function select(string $table, array $fields): SQLQueryBuilder;
    public function where(string $fields, string $value, string $operator = '='): SQLQueryBuilder;
    public function limit(int $start, int $offset): SQLQueryBuilder;
    public function getSQL(): string;
}