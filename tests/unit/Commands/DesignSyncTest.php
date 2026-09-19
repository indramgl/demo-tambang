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

        // Verify typography tokens are present
        $this->assertStringContainsString('--font-display-mega-size', $content, 'tokens.css must contain --font-display-mega-size');
        $this->assertStringContainsString('--font-display-hero-size', $content, 'tokens.css must contain --font-display-hero-size');
        $this->assertStringContainsString('--font-section-heading-size', $content, 'tokens.css must contain --font-section-heading-size');
        $this->assertStringContainsString('--font-body-size', $content, 'tokens.css must contain --font-body-size');
        $this->assertStringContainsString('--font-caption-size', $content, 'tokens.css must contain --font-caption-size');

        // Verify elevation tokens are present
        $this->assertStringContainsString('--shadow-none', $content, 'tokens.css must contain --shadow-none');
        $this->assertStringContainsString('--shadow-focus', $content, 'tokens.css must contain --shadow-focus');
        $this->assertStringContainsString('--shadow-raised', $content, 'tokens.css must contain --shadow-raised');

        // Verify the :root block is properly formed
        $this->assertMatchesRegularExpression(
            '/:root\s*\{[^}]+\}/s',
            $content,
            'tokens.css must have a :root block containing all tokens'
        );
    }

    public function testDesignSyncExtractsTypographyTokens(): void
    {
        $tokensPath = FCPATH . 'assets/css/tokens.css';

        if (file_exists($tokensPath)) {
            unlink($tokensPath);
        }

        $output = shell_exec('php spark design:sync 2>&1');

        $this->assertFileExists($tokensPath, 'tokens.css must be created');
        $content = file_get_contents($tokensPath);

        // Verify typography tokens are present
        $this->assertStringContainsString('--font-display-mega-size', $content, 'tokens.css must contain --font-display-mega-size');
        $this->assertStringContainsString('--font-display-hero-size', $content, 'tokens.css must contain --font-display-hero-size');
        $this->assertStringContainsString('--font-section-heading-size', $content, 'tokens.css must contain --font-section-heading-size');
        $this->assertStringContainsString('--font-body-size', $content, 'tokens.css must contain --font-body-size');
        $this->assertStringContainsString('--font-caption-size', $content, 'tokens.css must contain --font-caption-size');

        // Verify all 12 roles have size tokens
        $this->assertStringContainsString('--font-display-mega-weight', $content, 'tokens.css must contain --font-display-mega-weight');
        $this->assertStringContainsString('--font-display-hero-weight', $content, 'tokens.css must contain --font-display-hero-weight');
        $this->assertStringContainsString('--font-display-mega-line-height', $content, 'tokens.css must contain --font-display-mega-line-height');
        $this->assertStringContainsString('--font-display-mega-letter-spacing', $content, 'tokens.css must contain --font-display-mega-letter-spacing');
    }

    public function testDesignSyncExtractsElevationTokens(): void
    {
        $tokensPath = FCPATH . 'assets/css/tokens.css';

        if (file_exists($tokensPath)) {
            unlink($tokensPath);
        }

        $output = shell_exec('php spark design:sync 2>&1');

        $this->assertFileExists($tokensPath, 'tokens.css must be created');
        $content = file_get_contents($tokensPath);

        // Verify elevation tokens are present
        $this->assertStringContainsString('--shadow-none', $content, 'tokens.css must contain --shadow-none');
        $this->assertStringContainsString('--shadow-focus', $content, 'tokens.css must contain --shadow-focus');
        $this->assertStringContainsString('--shadow-raised', $content, 'tokens.css must contain --shadow-raised');
    }

    public function testDesignSyncHasTypographyAndElevationMethods(): void
    {
        $commandFile = APPPATH . 'Commands/DesignSync.php';
        $content = file_get_contents($commandFile);

        $this->assertStringContainsString('extractTypographyTokens', $content, 'DesignSync must have extractTypographyTokens method');
        $this->assertStringContainsString('extractElevationTokens', $content, 'DesignSync must have extractElevationTokens method');
    }
}
