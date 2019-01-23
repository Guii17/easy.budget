<?php

namespace Components\Database;

class Repository implements DatabaseInterface
{

    private $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getPDO(): \PDO
    {
        return $this->connection;
    }
}