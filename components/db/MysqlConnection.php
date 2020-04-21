<?php

namespace components\db;

use components\Config;
use components\interfaces\ContainerInterface;
use components\interfaces\DbConnectionInerface;
use PDO;
use PDOStatement;

class MysqlConnection implements DbConnectionInerface
{
    protected $options;

    /** @var PDO */
    private $pdo;

    /** @var PDOStatement */
    private $stmt;

    private static $defaultOptions = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    /**
     * @param ContainerInterface $container
     * @throws \Exception
     */
    public function __construct(ContainerInterface $container)
    {
        if (!$this->pdo) {
            /** @var Config $config */
            $config = $container->get(Config::class);
            $this->pdo = new PDO(
                $config->getRequired('db.dsn'),
                $config->getRequired('db.user'),
                $config->getRequired('db.passwd'),
                $this->options ?: self::$defaultOptions
            );
        }
    }

    /**
     * @param $sql
     * @param $params
     * @return bool
     */
    public function exec(string $sql, ?array $params = null): bool
    {
        $this->stmt = $this->pdo->prepare($sql);
        return $this->stmt->execute($params);
    }

    /**
     * @return PDOStatement
     */
    public function getStmt(): PDOStatement
    {
        return $this->stmt;
    }
}
