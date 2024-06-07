<?php

namespace App\Console\Commands\Audio;

use App\Console\Utils\Utils;
use Illuminate\Console\Command;

class TtsConversationCommand extends Command
{
    protected $signature = 'audio:tts-conversation {input} {output}';

    protected $description = 'Provides a text-to-speech conversation split by double line breaks.';

    public function handle()
    {
        $savePath = '/tmp/tts-conversation-' . time();
        mkdir($savePath, 0755, true);

        if(file_exists($this->argument('input'))) {
            $conversationParts = explode("\n\n", file_get_contents($this->argument('input')));
            foreach($conversationParts as $index => $part) {
                \Artisan::call('audio:tts', [
                    'input' => $part,
                    'output' => $savePath . '/part-' . $index . '.wav',
                    '--voice' => $index % 2 == 0 ? 'en-GB-SoniaNeural' : 'en-US-AriaNeural',
                ]);
            }
            \Artisan::call('audio:merge', [
                'directory' => $savePath,
                'output' => $this->argument('output'),
            ]);
        }
    }
}
