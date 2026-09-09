<?php

namespace Tests\Unit\Commands;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class RenderPagesTest extends CIUnitTestCase
{
    public function testRenderPagesCommandExists(): void
    {
        $commandFile = APPPATH . 'Commands/RenderPages.php';
        $this->assertFileExists($commandFile, 'RenderPages.php command file must exist');
    }

    public function testRenderPagesCommandHasCorrectName(): void
    {
        $commandFile = APPPATH . 'Commands/RenderPages.php';
        $this->assertFileExists($commandFile);
        $content = file_get_contents($commandFile);
        $this->assertStringContainsString(
            'render:pages',
            $content,
            'RenderPages command must be registered as render:pages'
        );
    }

    public function testRenderPagesCommandUsesParsedown(): void
    {
        $commandFile = APPPATH . 'Commands/RenderPages.php';
        $this->assertFileExists($commandFile);
        $content = file_get_contents($commandFile);
        $this->assertStringContainsString(
            'Parsedown',
            $content,
            'RenderPages command must use Parsedown for markdown conversion'
        );
    }

    public function testRenderPagesCommandScansPagesDirectory(): void
    {
        $commandFile = APPPATH . 'Commands/RenderPages.php';
        $this->assertFileExists($commandFile);
        $content = file_get_contents($commandFile);
        $this->assertStringContainsString(
            'app/Views/pages',
            $content,
            'RenderPages command must scan app/Views/pages/'
        );
    }

    public function testRenderPagesCommandOutputsToPublicContent(): void
    {
        $commandFile = APPPATH . 'Commands/RenderPages.php';
        $this->assertFileExists($commandFile);
        $content = file_get_contents($commandFile);
        $this->assertStringContainsString(
            'public/content',
            $content,
            'RenderPages command must output to public/content/'
        );
    }
}
