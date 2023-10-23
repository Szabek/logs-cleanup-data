<?php

namespace Szabson\LogsCleanupData\Factory;

use Szabson\LogsCleanupData\Logger\DatabaseLogger;
use Szabson\LogsCleanupData\Logger\LoggerInterface;

class DatabaseLoggerFactory
{
    public function create(): LoggerInterface
    {
        return new DatabaseLogger();
    }
}