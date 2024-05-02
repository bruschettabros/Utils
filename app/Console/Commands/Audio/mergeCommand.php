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

    public function handle(): ?int
    {
        if (!Utils::commandExists('ffmpeg')) {
            $this->error('FFMPEG is not installed.');
            return 1;
        }

        return Utils::command('ffmpeg', [
            '-i',
            'concat:' => $this->generateList(),
            '-acodec',
            'copy ' => $this->argument('output'),
        ])->exitCode();
    }

    private function generateList(): string
    {
        return collect(File::allFiles($this->argument('directory')))
            ->map(fn ($file) => $file->getRealPath())
            ->sort(fn ($a, $b) => Utils::getChapterFromFileName($a) <=> Utils::getChapterFromFileName($b))
            ->implode('|');
    }
}
