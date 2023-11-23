<?php

namespace MyProject\Services;

use MyProject\Exceptions\DbException;

class Db
{
    /**
     * @var \PDO
     */
    private $pdo;

    private static ?Db $instance = null;

    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];

        try {
            $this->pdo = new \PDO(
                'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
                $dbOptions['user'],
                $dbOptions['password']
            );
            $this->pdo->exec('SET NAMES UTF8');
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new DbException('Ошибка при подключении к базе данных: ' . $e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @throws DbException
     */
    public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        try {
            $sth = $this->pdo->prepare($sql);
            $sth->execute($params);
        } catch (\PDOException $e) {
            throw new DbException('Ошибка в запросе к базе данных: ' . $e->getMessage());
        }

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}