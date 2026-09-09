<?php

namespace Tests\Unit\Views;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class LayoutTest extends CIUnitTestCase
{
    public function testMainLayoutExists(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile, 'app/Views/layouts/main.php must exist');
    }

    public function testMainLayoutHasNavbarInclude(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile);
        $content = file_get_contents($layoutFile);
        $this->assertStringContainsString(
            "\$this->include('layouts/navbar')",
            $content,
            'main.php must include layouts/navbar'
        );
    }

    public function testMainLayoutHasContentArea(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile);
        $content = file_get_contents($layoutFile);
        $this->assertStringContainsString(
            '<main id="content">',
            $content,
            'main.php must have <main id="content">'
        );
    }

    public function testMainLayoutHasFooterInclude(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile);
        $content = file_get_contents($layoutFile);
        $this->assertStringContainsString(
            "\$this->include('layouts/footer')",
            $content,
            'main.php must include layouts/footer'
        );
    }

    public function testMainLayoutUsesEscLocale(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile);
        $content = file_get_contents($layoutFile);
        $this->assertStringContainsString(
            'esc($locale)',
            $content,
            'main.php must use esc($locale) for html lang attribute'
        );
    }

    public function testMainLayoutUsesBaseUrlStylesheet(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile);
        $content = file_get_contents($layoutFile);
        $this->assertStringContainsString(
            "base_url('assets/css/main.css')",
            $content,
            'main.php must reference stylesheet via base_url'
        );
    }

    public function testNavbarExists(): void
    {
        $navbarFile = APPPATH . 'Views/layouts/navbar.php';
        $this->assertFileExists($navbarFile, 'app/Views/layouts/navbar.php must exist');
    }

    public function testNavbarHasAllSixLocaleLinks(): void
    {
        $navbarFile = APPPATH . 'Views/layouts/navbar.php';
        $this->assertFileExists($navbarFile);
        $content = file_get_contents($navbarFile);
        foreach (['id', 'en', 'zh', 'fr', 'es', 'ja'] as $locale) {
            $this->assertStringContainsString(
                "'{$locale}/'",
                $content,
                "navbar must have language switcher link for /{$locale}/"
            );
        }
    }

    public function testNavbarUsesEscLocale(): void
    {
        $navbarFile = APPPATH . 'Views/layouts/navbar.php';
        $this->assertFileExists($navbarFile);
        $content = file_get_contents($navbarFile);
        $this->assertStringContainsString(
            'esc($locale)',
            $content,
            'navbar.php must use esc($locale)'
        );
    }

    public function testFooterExists(): void
    {
        $footerFile = APPPATH . 'Views/layouts/footer.php';
        $this->assertFileExists($footerFile, 'app/Views/layouts/footer.php must exist');
    }

    public function testFooterHasCopyright(): void
    {
        $footerFile = APPPATH . 'Views/layouts/footer.php';
        $this->assertFileExists($footerFile);
        $content = file_get_contents($footerFile);
        $this->assertStringContainsString(
            'PT Indah Tambang Raya Semesta',
            $content,
            'footer.php must contain copyright text'
        );
    }
}
