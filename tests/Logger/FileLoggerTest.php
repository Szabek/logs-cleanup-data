<?php

namespace Logger;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Szabson\LogsCleanupData\Logger\FileLogger;
use Szabson\LogsCleanupData\Storage\Filesystem;

class FileLoggerTest extends TestCase
{
    private string $logDir;
    private string $logFile;

    public function setUp(): void
    {
        $this->logDir = sys_get_temp_dir() . '/logs';
        if (!file_exists($this->logDir)) {
            mkdir($this->logDir);
        }

        $this->logFile = $this->logDir . '/testlog';
        touch($this->logFile);
    }

    public function testAddLog()
    {
        $filesystem = new Filesystem();
        $logger = new FileLogger($this->logFile, $filesystem);

        $logMessage = 'Test log message';
        $logger->add($logMessage);

        $logContents = file_get_contents($this->logFile);

        $this->assertStringContainsString(date('Y-m-d H:i:s') . ' - ' . $logMessage, $logContents);
    }

    public function testListLogs()
    {
        $filesystem = new Filesystem();
        $logger = new FileLogger($this->logFile, $filesystem);

        $currentDate = date('Y-m-d H:i:s');

        $logContents = "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP." . PHP_EOL;
        $logContents .= "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP.";

        file_put_contents($this->logFile, $logContents);

        $expectedLogs = [
            "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP.",
            "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP."
        ];

        $this->assertEquals($expectedLogs, $logger->list());
    }

    /**
     * @throws Exception
     */
    public function testClearLogs()
    {
        $this->setUp();

        $filesystem = new Filesystem();
        $logger = new FileLogger($this->logFile, $filesystem);

        $currentDate = date('Y-m-d H:i:s');
        $fiveDaysAgo = date('Y-m-d H:i:s', strtotime('-5 days'));
        $tenDaysAgo = date('Y-m-d H:i:s', strtotime('-10 days'));

        $logContents = "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP." . PHP_EOL;
        $logContents .= "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP." . PHP_EOL;
        $logContents .= "[$fiveDaysAgo] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP." . PHP_EOL;
        $logContents .= "[$fiveDaysAgo] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP." . PHP_EOL;
        $logContents .= "[$tenDaysAgo] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP." . PHP_EOL;
        $logContents .= "[$tenDaysAgo] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP.";

        file_put_contents($this->logFile, $logContents);

        $logger->clear(5);

        $expectedLogs = [
            "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP.",
            "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP.",
            "[$fiveDaysAgo] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP.",
            "[$fiveDaysAgo] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP."
        ];

        $this->assertEquals($expectedLogs, $logger->list());

        $logger->clear(2);

        $expectedLogs = [
            "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP.",
            "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP."
        ];

        $this->assertEquals($expectedLogs, $logger->list());
    }

    public function testRemoveLogFile()
    {
        $filesystem = new Filesystem();
        $logger = new FileLogger($this->logFile, $filesystem);

        $logger->remove();

        $this->assertFalse($filesystem->exist($this->logFile));
    }

    public function tearDown(): void
    {
        unlink($this->logFile);
        rmdir($this->logDir);
    }
}