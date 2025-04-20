<?php

namespace Larkbu\LonelySpace\Service;

use Larkbu\LonelySpace\Exception\DbException;


class Db
{
    /** @var PDO */
    private $pdo;

    /** @var Db */
    private static $instance;

    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../Config/connection.php');

        try {
            $this->pdo = new \PDO(
                'pgsql:host=' . $dbOptions['host'] . ';port=' . $dbOptions['port'] . ';dbname=' . $dbOptions['dbname'] . ';user=' . $dbOptions['user'] . ';password=' . $dbOptions['password'],
            );
        } catch (\PDOException $th) {
            throw new DbException('Error connection data base: ' . $th->getMessage());
        }

    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function query(string $postgres, $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($postgres);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function getLastInsertId(): int
    {
        return (int)$this->pdo->lastInsertId();
    }
}
