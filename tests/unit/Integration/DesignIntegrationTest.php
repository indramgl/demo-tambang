<?php

namespace Tests\Unit\Integration;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class DesignIntegrationTest extends CIUnitTestCase
{
    public function testLayoutFileExists(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile, 'Layout file app/Views/layouts/main.php must exist');
    }

    public function testLayoutIncludesMainCss(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile, 'Layout file must exist');

        $content = file_get_contents($layoutFile);
        $this->assertStringContainsString(
            'assets/css/main.css',
            $content,
            'Layout must include main.css stylesheet'
        );
    }

    public function testComposerHasPostInstallCmd(): void
    {
        $composerJson = json_decode(file_get_contents(ROOTPATH . 'composer.json'), true);

        $this->assertArrayHasKey(
            'scripts',
            $composerJson,
            'composer.json must have a scripts section'
        );

        $this->assertArrayHasKey(
            'post-install-cmd',
            $composerJson['scripts'],
            'composer.json scripts must have post-install-cmd'
        );

        $postInstallCmds = $composerJson['scripts']['post-install-cmd'];
        $this->assertContains(
            'php spark design:sync',
            $postInstallCmds,
            'post-install-cmd must include php spark design:sync'
        );
    }

    public function testDesignSyncRegeneratesTokensCss(): void
    {
        $tokensPath = FCPATH . 'assets/css/tokens.css';

        // Ensure tokens.css exists before running
        $this->assertFileExists($tokensPath, 'tokens.css must exist before running design:sync');

        // Run the command
        $output = shell_exec('php spark design:sync 2>&1');

        // Verify tokens.css still exists after running
        $this->assertFileExists($tokensPath, 'tokens.css must exist after running design:sync');

        // Verify it contains :root block
        $content = file_get_contents($tokensPath);
        $this->assertStringContainsString(':root', $content, 'tokens.css must contain :root block');
        $this->assertStringContainsString('--bg', $content, 'tokens.css must contain --bg token');
    }
}
