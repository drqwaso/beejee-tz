<?php

namespace components\interfaces;

use PDOStatement;

interface DbConnectionInerface
{
    /**
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function exec(string $sql, ?array $params = null): bool;

    /**
     * @return PDOStatement
     */
    public function getStmt(): PDOStatement;
}
