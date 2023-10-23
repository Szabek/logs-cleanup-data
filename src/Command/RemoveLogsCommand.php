<?php

namespace Szabson\LogsCleanupData\Command;

use Exception;
use Szabson\LogsCleanupData\Factory\LoggerFactoryInterface;

class RemoveLogsCommand
{
    private LoggerFactoryInterface $loggerFactory;

    public function __construct(LoggerFactoryInterface $loggerFactory)
    {
        $this->loggerFactory = $loggerFactory;
    }

    /**
     * @throws Exception
     */
    public function handle(int $daysToKeep): void
    {
        $logger = $this->loggerFactory->create();
        $logger->clear($daysToKeep);
    }
}