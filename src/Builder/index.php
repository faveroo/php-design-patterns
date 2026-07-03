<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Patterns\Builder\Builders\PostgresQueryBuilder;
use Patterns\Builder\Contracts\SQLQueryBuilder;
use Patterns\Builder\Builders\MysqlQueryBuilder;

function clientCode(SQLQueryBuilder $queryBuilder): void {
    $query = $queryBuilder
        ->select("users", ["name, email, password"])
        ->where("age", 18, ">")
        ->where("age", 30, "<")
        ->limit(10, 20)
        ->getSQL();

    echo $query;
}

echo "Testing MySQL query builder:\n";
clientCode(new MysqlQueryBuilder());

echo "\n\n";

echo "Testing PostgresSQL query builder:\n";
clientCode(new PostgresQueryBuilder());