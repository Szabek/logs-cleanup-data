<?php

namespace Command;

use Exception;
use PHPUnit\Framework\TestCase;
use Szabson\LogsCleanupData\Command\RemoveLogsCommand;
use Szabson\LogsCleanupData\Factory\FileLoggerFactory;
use Szabson\LogsCleanupData\Storage\Filesystem;

class RemoveLogsCommandTest extends TestCase
{
    protected FileLoggerFactory $fileLoggerFactory;
    protected Filesystem $filesystem;

    protected function setUp(): void
    {
        $this->filesystem = new Filesystem();
        $this->fileLoggerFactory = new FileLoggerFactory('file.txt', $this->filesystem);
    }

    /**
     * @throws Exception
     */
    public function testClearOldLogs()
    {
        $currentDate = date('Y-m-d H:i:s');
        $previousDate = date('Y-m-d H:i:s', strtotime('-5 days', strtotime($currentDate)));
        $logContents = "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP." . PHP_EOL;
        $logContents .= "[$previousDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP." . PHP_EOL;
        $logContents .= "[2023-09-20 10:15:32] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP" . PHP_EOL;
        $logContents .= "[2023-06-20 10:15:32] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP" . PHP_EOL;
        $logContents .= "[2023-01-20 10:15:32] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP";

        file_put_contents('file.txt', $logContents);

        $removeLogsCommand = new RemoveLogsCommand($this->fileLoggerFactory);

        $removeLogsCommand->handle(10);

        $expectedResult = "[$currentDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP." . PHP_EOL;
        $expectedResult .= "[$previousDate] - Błąd - Aplikacja X napotkała wyjątek podczas przetwarzania żądania HTTP." . PHP_EOL;
        $this->assertEquals(
            str_replace(array("\n", "\r"), '', $expectedResult),
            str_replace(array("\n", "\r"), '', file_get_contents('file.txt'))
        );
    }

    protected function tearDown(): void
    {
        unlink('file.txt');
    }
}