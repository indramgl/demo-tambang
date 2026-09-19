<?php

namespace Tests\Unit\Views;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class PageViewsTest extends CIUnitTestCase
{
    private array $pages = [
        'home',
        'history',
        'vision-mission',
        'services',
        'contact',
        'portfolio',
        'investor',
        'about',
    ];

    public function testAllPageViewsExist(): void
    {
        foreach ($this->pages as $page) {
            $viewFile = APPPATH . "Views/pages/{$page}.php";
            $this->assertFileExists(
                $viewFile,
                "app/Views/pages/{$page}.php must exist"
            );
        }
    }

    public function testEachPageExtendsMainLayout(): void
    {
        foreach ($this->pages as $page) {
            $viewFile = APPPATH . "Views/pages/{$page}.php";
            $this->assertFileExists($viewFile);
            $content = file_get_contents($viewFile);
            $this->assertStringContainsString(
                "\$this->extend('layouts/main')",
                $content,
                "{$page}.php must extend layouts/main"
            );
        }
    }

    public function testEachPageHasContentSection(): void
    {
        foreach ($this->pages as $page) {
            $viewFile = APPPATH . "Views/pages/{$page}.php";
            $this->assertFileExists($viewFile);
            $content = file_get_contents($viewFile);
            $this->assertStringContainsString(
                "\$this->section('content')",
                $content,
                "{$page}.php must define content section"
            );
        }
    }

    public function testEachPageUsesEscTitle(): void
    {
        foreach ($this->pages as $page) {
            $viewFile = APPPATH . "Views/pages/{$page}.php";
            $this->assertFileExists($viewFile);
            $content = file_get_contents($viewFile);
            $this->assertStringContainsString(
                'esc($title)',
                $content,
                "{$page}.php must use esc(\$title)"
            );
        }
    }

    public function testEachPageUsesEscLocale(): void
    {
        foreach ($this->pages as $page) {
            $viewFile = APPPATH . "Views/pages/{$page}.php";
            $this->assertFileExists($viewFile);
            $content = file_get_contents($viewFile);
            $this->assertStringContainsString(
                'esc($locale)',
                $content,
                "{$page}.php must use esc(\$locale)"
            );
        }
    }

    public function testNoHardcodedLocaleInOutput(): void
    {
        foreach ($this->pages as $page) {
            $viewFile = APPPATH . "Views/pages/{$page}.php";
            $this->assertFileExists($viewFile);
            $content = file_get_contents($viewFile);
            // Check that locale-dependent output uses esc($locale), not hardcoded strings
            // Look for patterns like echoing locale directly without esc()
            $this->assertDoesNotMatchRegularExpression(
                '/echo\s+\$locale\b/',
                $content,
                "{$page}.php must not echo \$locale directly without esc()"
            );
        }
    }

    public function testAboutPageHasTentangContent(): void
    {
        $viewFile = APPPATH . 'Views/pages/about.php';
        $this->assertFileExists($viewFile);
        $content = file_get_contents($viewFile);
        $this->assertStringContainsString('Tentang Kami', $content);
    }

    public function testAboutPageUsesCorrectLocaleText(): void
    {
        $viewFile = APPPATH . 'Views/pages/about.php';
        $this->assertFileExists($viewFile);
        $content = file_get_contents($viewFile);
        $this->assertStringContainsString(
            "esc(\$locale) === 'id' ? 'Tentang Kami' : 'About Us'",
            $content,
            'about.php must contain locale-conditional text for About Us'
        );
        $this->assertStringContainsString(
            "esc(\$locale) === 'id' ? 'Visi Misi' : 'Vision & Mission'",
            $content,
            'about.php must contain locale-conditional text for Vision & Mission'
        );
    }
}
