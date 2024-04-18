<?php

namespace Tests\Unit;

use App\Console\Utils\Utils;
use Tests\TestCase;

class UtilsTest extends TestCase
{
    public function testCommandExists(): void
    {
        $this->assertTrue(Utils::commandExists('ls'));
        $this->assertTrue(Utils::commandExists('cat'));

        $this->assertFalse(Utils::commandExists('fakeCommand'));
        $this->assertFalse(Utils::commandExists('fakeCommand2'));
    }

    public function testChapterFromFile(): void
    {
        $this->assertIsNumeric(Utils::getChapterFromFileName('filename-1.mp3'));
        $this->assertEquals(1, Utils::getChapterFromFileName('filename-1.mp3'));
        $this->assertEquals(23, Utils::getChapterFromFileName('filename-23.mp3'));
        $this->assertEquals(456, Utils::getChapterFromFileName('filename-456.mp3'));
    }

    public function testCommand(): void
    {
        $this->assertEquals(base_path() . PHP_EOL, Utils::command('pwd')->output());
        $this->assertEquals('Hello World! World Hello!' . PHP_EOL, Utils::command('echo', ['Hello' => 'World!'], ['World' => 'Hello!'])->output());
    }
}
