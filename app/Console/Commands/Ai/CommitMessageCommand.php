<?php

namespace App\Console\Commands\Ai;

use App\Console\Utils\Utils;
use function Laravel\Prompts\spin;

class CommitMessageCommand extends InteractCommand
{
    protected $signature = 'ai:commit-message {directory} {temperature=1 : The temperature of the model, can be between 0 and 1}';

    protected $description = 'Generates a commit message for a given directory based on the git diff';

    public function handle(): void
    {
        $this->messages[] = ['role' => 'system', 'content' => 'You write git commit messages'];

        $output = spin(fn () => $this->chat(sprintf(
            'Give me a git commit message based on this git diff: ```%s```',
            Utils::command('git', '-C', $this->argument('directory'), 'diff')->output()
        )), 'Thinking...');

        $this->info($output);
    }
}
