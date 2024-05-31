<?php

namespace App\Console\Commands\Audio;

use App\Console\Utils\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

class mergeCommand extends Command
{
    protected $signature = 'audio:merge {directory} {output}';

    protected $description = 'Merge audio files together using FFMPEG.';

    public function handle()
    {
        if (!Utils::commandExists('ffmpeg')) {
            $this->error('FFMPEG is not installed.');
            return 1;
        }
        $result = Process::run(sprintf(
            "ffmpeg -i 'concat:%s' -acodec copy %s",
            $this->generateList(),
            $this->argument('output')
        ));
        return $result->exitCode();
    }

    public function generateList(): string
    {
        $files = [];

        foreach (File::allFiles($this->argument('directory')) as $file) {
            preg_match('/\d+(?=.)/', $file->getFilename(), $matches);
            $files[$matches[0]] = $file->getRealPath();
        }
        ksort($files);
        return implode('|',$files);
    }
}
