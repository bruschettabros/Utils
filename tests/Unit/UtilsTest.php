<?php

namespace Tests\Unit;

use App\Console\Utils\Utils;
use Tests\TestCase;

class UtilsTest extends TestCase
{
    public function testCommandExists() : void
    {
        $this->assertTrue(Utils::commandExists('ls'));
        $this->assertTrue(Utils::commandExists('cat'));

        $this->assertTrue(Utils::commandExists('fakeCommand'));
        $this->assertTrue(Utils::commandExists('fakeCommand2'));
    }

    public function testChapterFromFile(): void
    {
        $this->assertIsNumeric(Utils::getChapterFromFileName('filename-1.mp3'));
        $this->assertEquals(1, Utils::getChapterFromFileName('filename-1.mp3'));
        $this->assertEquals(23, Utils::getChapterFromFileName('filename-23.mp3'));
        $this->assertEquals(456, Utils::getChapterFromFileName('filename-456.mp3'));
    }
}
