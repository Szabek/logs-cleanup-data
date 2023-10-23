<?php

namespace Szabson\LogsCleanupData\Factory;

use Szabson\LogsCleanupData\Logger\LoggerInterface;

interface LoggerFactoryInterface
{
    public function create(): LoggerInterface;
}