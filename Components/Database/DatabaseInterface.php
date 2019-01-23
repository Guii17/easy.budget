<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/01/2019
 * Time: 23:42
 */

namespace Components\Database;


interface DatabaseInterface
{
    public function __construct(\PDO $connection);

    public function getPDO(): \PDO;
}