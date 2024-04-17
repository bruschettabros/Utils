<?php

namespace App\Console\Utils;

use Illuminate\Support\Facades\Process;

class Utils
{
    public static function commandExists(string $command): bool
    {
    $result = Process::run(sprintf('which %s', $command));
    return $result->output() !== sprintf('%s not found', $command);
    }

    public static function getChapterFromFileName($file): int
    {
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $value = (int) filter_var($fileName, FILTER_SANITIZE_NUMBER_INT);
        return abs($value);
    }
}
