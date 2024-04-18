<?php

namespace App\Console\Commands\Audio;

use App\Console\Utils\Utils;

class TtsVoicesCommand extends TtsCommand
{
    protected $signature = 'audio:tts-voices';

    protected $description = 'Lists Available voices to use with the TTS service.';

    public function handle(): int
    {
        $this->checkCommand();

        $result = Utils::command(self::COMMAND, [
            '--list-voices'
        ]);
        $this->info($result->output());
        return $result->exitCode();
    }
}
