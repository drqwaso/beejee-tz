<?php

namespace components\interfaces;

use PDOStatement;

interface DaoInterface
{
    /**
     * @param string $sql
     * @param array|null $params
     * @return PDOStatement
     */
    public function query(string $sql, ?array $params = null): PDOStatement;

    /**
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function exec(string $sql, ?array $params = null): bool;
}
