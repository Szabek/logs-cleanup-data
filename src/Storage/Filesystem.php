<?php

namespace Szabson\LogsCleanupData\Storage;

class Filesystem implements FilesystemInterface
{
    public function mkdir($path, $mode = 0777, $recursive = false): bool
    {
        if (!$this->exist($path)) {
            return mkdir($path, $mode, $recursive);
        }

        return false;
    }

    public function exist($path): bool
    {
        return file_exists($path);
    }

    public function readFile($path): false|string
    {
        if ($this->exist($path)) {
            return file_get_contents($path);
        }

        return false;
    }

    public function dumpFile($file, $data): false|int
    {
        return file_put_contents($file, $data);
    }

    public function appendFile($file, $data): false|int
    {
        return file_put_contents($file, $data, FILE_APPEND);
    }

    public function unlinkFile($file): bool
    {
        if ($this->exist($file)) {
            return unlink($file);
        }

        return false;
    }
}