<?php

namespace App\Console\Commands\Audio;

use App\Console\Utils\Utils;
use Illuminate\Console\Command;

class TtsCommand extends Command
{
    protected const COMMAND = '.venv/bin/edge-tts';
    protected $signature = 'audio:tts {input} {output} {--voice=en-GB-SoniaNeural : The voice to use}';

    protected $description = 'Provides a text-to-speech service.';

    public function handle(): int
    {
        $this->checkCommand();

        $result = Utils::command(self::COMMAND, [
            '--text' => $this->processInput($this->argument('input')),
            '--write-media' => $this->argument('output'),
            '--voice' => $this->option('voice'),
        ]);

        $this->info($result->command());

        $this->info($result->output());
        return $result->exitCode();
    }

    protected function checkCommand(): void
    {
        if (!file_exists(self::COMMAND)) {
            $this->error(sprintf(
                'Text-to-speech service is not available. install %s: %s',
                self::COMMAND,
                'https://github.com/rany2/edge-tts',
            ));
        }
    }

    private function processInput(string $argument): string
    {
        if (file_exists($argument)) {
            $argument = file_get_contents($argument);
        }

        return sprintf('"%s"', addslashes($argument));
    }
}
