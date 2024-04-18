<?php

namespace App\Console\Utils;

use Illuminate\Contracts\Process\ProcessResult as ProcessResultContact;
use Illuminate\Process\ProcessResult;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class Utils
{
    public static function commandExists(string $command): bool
    {
        $result = Process::run(sprintf('which %s', $command))->output();
        return $result !== sprintf('%s not found', $command) && $result !== '';
    }

    public static function getChapterFromFileName($file): int
    {
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $value = (int) filter_var($fileName, FILTER_SANITIZE_NUMBER_INT);
        return abs($value);
    }

    public static function command(string $command, ...$arguments): ProcessResult|ProcessResultContact
    {
        collect($arguments)->each(function ($argument) use (&$command) {
            if (is_array($argument)) {
                $string = Str::of('');

                collect($argument)->each(function ($value, $key) use (&$string) {
                    $string = $string->append(sprintf(' %s %s', is_numeric($key) ? null : $key, $value));
                });

                $argument = (string) $string;
            }
            $command .= sprintf(' %s', $argument);
        });
        return Process::run($command);
    }
}
