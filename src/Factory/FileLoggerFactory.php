<?php

namespace Szabson\LogsCleanupData\Factory;

use Szabson\LogsCleanupData\Logger\FileLogger;
use Szabson\LogsCleanupData\Logger\LoggerInterface;
use Szabson\LogsCleanupData\Storage\Filesystem;

class FileLoggerFactory implements LoggerFactoryInterface
{
    private string $filePath;
    private Filesystem $filesystem;

    public function __construct($filePath, Filesystem $filesystem)
    {
        $this->filePath = $filePath;
        $this->filesystem = $filesystem;
    }

    public function create(): LoggerInterface
    {
        return new FileLogger($this->filePath, $this->filesystem);
    }
}