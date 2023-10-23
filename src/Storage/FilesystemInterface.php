<?php

namespace Szabson\LogsCleanupData\Storage;

interface FilesystemInterface
{
    public function mkdir($path, $mode = 0777, $recursive = false);
    public function exist($path);
    function readFile($path);
    public function dumpFile($file, $data);
    public function appendFile($file, $data);
    public function unlinkFile($file);
}