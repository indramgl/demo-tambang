<?php

namespace Tests\Unit\Commands;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class DesignSyncTest extends CIUnitTestCase
{
    public function testDesignSyncCommandExists(): void
    {
        $commandFile = APPPATH . 'Commands/DesignSync.php';
        $this->assertFileExists($commandFile, 'DesignSync.php command file must exist');
    }

    public function testDesignSyncGeneratesTokensCss(): void
    {
        $tokensPath = FCPATH . 'assets/css/tokens.css';

        // Ensure tokens.css does not exist before running the command
        if (file_exists($tokensPath)) {
            unlink($tokensPath);
        }

        // Run the command via shell
        $output = shell_exec('php spark design:sync 2>&1');

        // Verify tokens.css was created
        $this->assertFileExists($tokensPath, 'tokens.css must be created by design:sync command');

        // Verify it contains a :root block
        $content = file_get_contents($tokensPath);
        $this->assertStringContainsString(':root', $content, 'tokens.css must contain a :root block');

        // Verify it contains design token custom properties
        $this->assertStringContainsString('--bg', $content, 'tokens.css must contain --bg token');
        $this->assertStringContainsString('--surface', $content, 'tokens.css must contain --surface token');
        $this->assertStringContainsString('--fg', $content, 'tokens.css must contain --fg token');
        $this->assertStringContainsString('--accent', $content, 'tokens.css must contain --accent token');
        $this->assertStringContainsString('--success', $content, 'tokens.css must contain --success token');
        $this->assertStringContainsString('--warn', $content, 'tokens.css must contain --warn token');
        $this->assertStringContainsString('--danger', $content, 'tokens.css must contain --danger token');
        $this->assertStringContainsString('--border', $content, 'tokens.css must contain --border token');
        $this->assertStringContainsString('--radius-', $content, 'tokens.css must contain --radius- tokens');
        $this->assertStringContainsString('--space-', $content, 'tokens.css must contain --space- tokens');

        // Verify the :root block is properly formed
        $this->assertMatchesRegularExpression(
            '/:root\s*\{[^}]+\}/s',
            $content,
            'tokens.css must have a :root block containing all tokens'
        );
    }
}
