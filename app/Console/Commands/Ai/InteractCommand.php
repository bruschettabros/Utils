<?php

namespace App\Console\Commands\Ai;

use App\Console\Utils\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use OpenAI\Client;

use function Laravel\Prompts\text;
use function Laravel\Prompts\spin;

class InteractCommand extends Command
{
    protected $signature = 'ai:interact';

    protected $description = 'Interact with Open API';

    protected const MODEL = 'gpt-3.5-turbo';

    protected array $messages = [];

    protected Client $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = Utils::OpenAiInstance();
    }

    public function handle(): void
    {
        while ($text = text(label: 'Ask Assistant')) {
            spin(fn () => $this->info($this->chat($text)), 'Thinking...');
        }
        if ($this->confirm('Dump this conversation?')) {
            $this->info(json_encode($this->messages, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
        }
        if ($this->confirm('Convert conversation to audio?')) {
            spin(fn () => $this->convertToAudio(), 'Converting to Audio...');
        }

    }

    private function chat(string $message): string
    {
        $this->messages[] = ['role' => 'user', 'content' => $message];
        $result = $this->client->chat()->create([
            'model' => self::MODEL,
            'messages' => $this->messages,
        ]);
        $this->messages[] = ['role' => 'assistant', 'content' => $result->choices[0]->message->content];
        return end($this->messages)['content'];

    }

    private function convertToAudio(): void
    {
        $messageString = '';
        collect($this->messages)->each(function ($message) use (&$messageString) {
            $messageString .= sprintf('%s. ', $message['content']);
        });
        Artisan::call('audio:tts', [
            'input' => $messageString,
            'output' => '~/Downloads/conversation.mp3',
        ]);
    }
}
