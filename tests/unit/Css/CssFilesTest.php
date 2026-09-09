<?php

namespace Tests\Unit\Css;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class CssFilesTest extends CIUnitTestCase
{
    public function testMainCssExists(): void
    {
        $this->assertFileExists(
            FCPATH . 'assets/css/main.css',
            'main.css must exist in public/assets/css/'
        );
    }

    public function testComponentsCssExists(): void
    {
        $this->assertFileExists(
            FCPATH . 'assets/css/components.css',
            'components.css must exist in public/assets/css/'
        );
    }

    public function testPagesCssExists(): void
    {
        $this->assertFileExists(
            FCPATH . 'assets/css/pages.css',
            'pages.css must exist in public/assets/css/'
        );
    }

    public function testResponsiveCssExists(): void
    {
        $this->assertFileExists(
            FCPATH . 'assets/css/responsive.css',
            'responsive.css must exist in public/assets/css/'
        );
    }

    public function testMainCssImportsTokensCss(): void
    {
        $content = file_get_contents(FCPATH . 'assets/css/main.css');
        $this->assertStringContainsString('@import', $content, 'main.css must use @import');
        $this->assertStringContainsString('tokens.css', $content, 'main.css must import tokens.css');
    }

    public function testMainCssContainsReset(): void
    {
        $content = file_get_contents(FCPATH . 'assets/css/main.css');
        $this->assertStringContainsString('margin', $content, 'main.css must contain reset margin styles');
        $this->assertStringContainsString('padding', $content, 'main.css must contain reset padding styles');
        $this->assertStringContainsString('box-sizing', $content, 'main.css must contain box-sizing reset');
    }

    public function testMainCssContainsContainer(): void
    {
        $content = file_get_contents(FCPATH . 'assets/css/main.css');
        $this->assertStringContainsString('.container', $content, 'main.css must contain .container class');
        $this->assertStringContainsString('max-width', $content, 'main.css must contain max-width');
    }

    public function testComponentsCssContainsButtonStyles(): void
    {
        $content = file_get_contents(FCPATH . 'assets/css/components.css');
        $this->assertStringContainsString('button', $content, 'components.css must contain button styles');
        $this->assertStringContainsString('border-radius', $content, 'components.css must contain border-radius for buttons');
    }

    public function testComponentsCssContainsCardStyles(): void
    {
        $content = file_get_contents(FCPATH . 'assets/css/components.css');
        $this->assertStringContainsString('.card', $content, 'components.css must contain .card styles');
    }

    public function testComponentsCssContainsNavStyles(): void
    {
        $content = file_get_contents(FCPATH . 'assets/css/components.css');
        $this->assertStringContainsString('nav', $content, 'components.css must contain nav styles');
    }

    public function testComponentsCssContainsFormStyles(): void
    {
        $content = file_get_contents(FCPATH . 'assets/css/components.css');
        $this->assertStringContainsString('input', $content, 'components.css must contain form input styles');
    }

    public function testComponentsCssUsesVarTokens(): void
    {
        $content = file_get_contents(FCPATH . 'assets/css/components.css');
        $this->assertStringContainsString('var(--', $content, 'components.css must use var(--*) custom properties');
    }

    public function testResponsiveCssHas720pxBreakpoint(): void
    {
        $content = file_get_contents(FCPATH . 'assets/css/responsive.css');
        $this->assertStringContainsString('720px', $content, 'responsive.css must have 720px breakpoint');
    }

    public function testResponsiveCssHas400pxBreakpoint(): void
    {
        $content = file_get_contents(FCPATH . 'assets/css/responsive.css');
        $this->assertStringContainsString('400px', $content, 'responsive.css must have 400px breakpoint');
    }

    public function testNoHardcodedHexInCssFiles(): void
    {
        $cssFiles = [
            'main.css' => file_get_contents(FCPATH . 'assets/css/main.css'),
            'components.css' => file_get_contents(FCPATH . 'assets/css/components.css'),
            'pages.css' => file_get_contents(FCPATH . 'assets/css/pages.css'),
            'responsive.css' => file_get_contents(FCPATH . 'assets/css/responsive.css'),
        ];

        foreach ($cssFiles as $name => $content) {
            // Check for hex colors that are NOT inside a :root block
            // We allow hex in :root but not elsewhere
            $rootBlock = '';
            if (preg_match('/:root\s*\{[^}]+\}/s', $content, $m)) {
                $rootBlock = $m[0];
            }

            $nonRootContent = str_replace($rootBlock, '', $content);

            // Look for hex colors (#xxx or #xxxxxx) outside :root
            $this->assertDoesNotMatchRegularExpression(
                '/#[0-9a-fA-F]{3,6}\b/',
                $nonRootContent,
                "$name must not contain hardcoded hex colors outside :root block"
            );
        }
    }
}
