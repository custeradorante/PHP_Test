<?php

class DB
{
	private $pdo;

	private static $instance = null;

	private function __construct()
	{
		$dsn = 'mysql:dbname=phptest;host=127.0.0.1;port=3306';
		$user = 'root';
		$password = 'pass';

		$this->pdo = new \PDO($dsn, $user, $password);
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
		$sth = $this->pdo->prepare($sql);
        $sth->execute($params);

        return $sth->fetchAll();
	}

	public function exec(string $sql, array $params = []): int
	{
		$sth = $this->pdo->prepare($sql);
		$sth->execute($params);

		return $sth->rowCount();
	}

	public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}
