<?php

class DB
{
	private $pdo;

	private static $instance = null;

	private function __construct()
	{
		$dsn = 'mysql:dbname=phptest;host=127.0.0.1;port=3308';
		$user = 'logistics';
		$password = 'logisticsadmin';
		try {
			$this->pdo = new \PDO($dsn, $user, $password);
		} catch (PDOException $e) {
			Logger::logError("Database connection failed: " . $e->getMessage());
			throw $e;
		}
	}

	public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

	public function select(string $sql, array $params = []): array
	{
		try {
			$sth = $this->pdo->prepare($sql);
			$sth->execute($params);

			return $sth->fetchAll();
		} catch (PDOException $e) {
			Logger::logError("Database select query failed: " . $e->getMessage());
			return [];
		}
	}

	public function exec(string $sql, array $params = []): int
	{
		try {
			$sth = $this->pdo->prepare($sql);
			$sth->execute($params);

			return $sth->rowCount();
		} catch (PDOException $e) {
			Logger::logError("Database exec query failed: " . $e->getMessage());
			return 0;
		}
	}

	public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}
