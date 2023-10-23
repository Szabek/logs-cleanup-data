<?php

namespace Szabson\LogsCleanupData\Logger;

interface LoggerInterface
{
    public function add($logMessage);
    public function list();
    public function clear($days);
    public function remove();
}