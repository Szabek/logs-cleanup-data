<?php

namespace Szabson\LogsCleanupData\Logger;

use Szabson\LogsCleanupData\Storage\Filesystem;

class FileLogger implements LoggerInterface
{
    private string $filePath;
    private Filesystem $filesystem;

    public function __construct($filePath, Filesystem $filesystem)
    {
        $this->filePath = $filePath;
        $this->filesystem = $filesystem;
    }

    public function add($logMessage): void
    {
        $currentContent = $this->fileContent();
        $currentContent .= date('Y-m-d H:i:s') . ' - ' . $logMessage . PHP_EOL;
        $this->filesystem->dumpFile($this->filePath, $currentContent);
    }

    public function list(): array
    {
        $content = $this->fileContent();

        return explode(PHP_EOL, $content);
    }

    public function clear($days): void
    {
        $content = $this->fileContent();
        $logs = explode(PHP_EOL, $content);
        $newLogs = [];
        $cutoffDate = strtotime(date('Y-m-d', strtotime("-$days days")));

        $datePattern = '/\d{4}-\d{2}-\d{2}/';

        foreach ($logs as $log) {

            if (preg_match($datePattern, $log, $matches)) {
                $logDate = strtotime($matches[0]);
            } else {
                continue;
            }

            if ($logDate >= $cutoffDate) {
                $newLogs[] = $log;
            }
        }

        $newContent = implode(PHP_EOL, $newLogs);
        $this->filesystem->dumpFile($this->filePath, $newContent);
    }

    public function remove(): void
    {
        $this->filesystem->unlinkFile($this->filePath);
    }

    private function fileContent(): false|string
    {
        return $this->filesystem->exist($this->filePath) ? $this->filesystem->readFile($this->filePath) : '';
    }
}