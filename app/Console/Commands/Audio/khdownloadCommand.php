<?php

namespace App\Console\Commands\Audio;

use HTMLDomParser\NodeFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class khdownloadCommand extends Command
{
    protected $signature = 'audio:khdownload {album} {format=flac}';

    protected $description = 'Downloads an album from KHInsider';

    private string $url = 'https://downloads.khinsider.com/';
    private string $uri = 'game-soundtracks/album/';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $albumName = $this->argument('album');
        $url = $this->url . $this->uri . $albumName;

        $this->getPageLinks($url)->each(function ($link) {
            try {
                $downloadFile = $this->getDownloadFile($link, $this->argument('format'));
                $this->info(sprintf("wget %s", $downloadFile));
            } catch (\Exception $e) {
                // Ignore
            }
        });
    }

    private function getDownloadFile(string $url, string $format = 'flac'): ?string
    {
        $response = Http::get($this->url . $url);
        $dom = NodeFactory::load($response->body());

        $hrefs = [];
        foreach ($dom->find('a') as $a) {
            $hrefs[] = $a->getAttribute('href');
        }
        return collect($hrefs)->unique()->filter(fn ($href) => str_contains($href, $format))->first();
    }

    private function getPageLinks(string $url): Collection
    {
        $response = Http::get($url);
        $dom = NodeFactory::load($response->body());

        $hrefs = [];
        foreach ($dom->find('tr') as $tr) {
            foreach ($tr->find('a') as $a) {
                $hrefs[] = $a->getAttribute('href');
            }
        }
        return collect($hrefs)->unique()->filter(fn ($href) => str_contains($href, '.mp3'));
    }
}
