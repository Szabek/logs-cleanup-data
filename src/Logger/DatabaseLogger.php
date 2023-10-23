<?php

namespace Szabson\LogsCleanupData\Logger;

class DatabaseLogger implements LoggerInterface
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function add($logMessage)
    {
        // TODO: Implement add() method.
    }

    public function list()
    {
        // TODO: Implement list() method.
    }

    public function clear($days)
    {
        // TODO: Implement clear() method.
    }

    public function remove()
    {
        // TODO: Implement remove() method.
    }
}