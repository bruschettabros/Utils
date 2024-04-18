<?php

namespace App\Console\Commands\Audio;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BookDownloadCommand extends Command
{
    protected $signature = 'audio:book-download {jsonFile} {name}';

    protected $description = 'Downloads an Audiobook from a provided JSON file.';

    public function handle(): void
    {
        collect(File::json($this->argument('jsonFile'))['playlist'])
            ->each(fn ($chapter) => $this->info($this->wgetCommand($chapter)));
    }

    private function wgetCommand($chapter): string
    {
        return sprintf(
            'wget "%s" -O %s-%s.mp3',
            $chapter["url"],
            $this->argument('name'),
            $chapter["chapter_number"]
        );
    }
}
