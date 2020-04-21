<?php

namespace components\db;

use components\interfaces\DaoInterface;
use components\interfaces\DbConnectionInerface;
use PDOStatement;

abstract class AbstractDao implements DaoInterface
{
    /** @var DbConnectionInerface */
    private $dbConnection;

    public function __construct(DbConnectionInerface $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * @inheritDoc
     */
    public function query(string $sql, ?array $params = null): PDOStatement
    {
        $this->dbConnection->exec($sql, $params);

        return $this->dbConnection->getStmt();
    }

    /**
     * @param string $sql
     * @param array|null $params
     * @return bool
     */
    public function exec(string $sql, ?array $params = null): bool
    {
        return $this->dbConnection->exec($sql, $params);
    }

    /**
     * @param array $data
     * @return array
     */
    public function hidrateCollection(array $data): array
    {
        $collection = [];

        foreach ($data as $item) {
            $collection[] = $this->hidrateObject($item);
        }

        return $collection;
    }

    /**
     * @param array $data
     * @return mixed
     */
    abstract public function hidrateObject(array $data);
}
