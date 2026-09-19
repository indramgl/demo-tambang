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

    public function testMainLayoutUsesRenderSection(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile);
        $content = file_get_contents($layoutFile);
        $this->assertStringContainsString(
            "\$this->renderSection('content')",
            $content,
            'main.php must use renderSection for content rendering'
        );
    }

    public function testMainLayoutDoesNotUseContentVariable(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile);
        $content = file_get_contents($layoutFile);
        $this->assertDoesNotMatchRegularExpression(
            '/<\?=\s*\\$content\s*\?>/',
            $content,
            'main.php must not use <?= $content ?> pattern'
        );
    }

    public function testMainLayoutNoLtrimServiceUri(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile);
        $content = file_get_contents($layoutFile);
        $this->assertStringNotContainsString(
            "ltrim(service('uri')->getPath()",
            $content,
            'main.php must not use ltrim(service(\'uri\')->getPath()) for URL generation'
        );
    }

    public function testMainLayoutHreflangUsesLocaleUrls(): void
    {
        $layoutFile = APPPATH . 'Views/layouts/main.php';
        $this->assertFileExists($layoutFile);
        $content = file_get_contents($layoutFile);
        $this->assertStringContainsString(
            '$localeUrls',
            $content,
            'main.php must use $localeUrls for hreflang tags'
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
        $this->assertStringContainsString(
            '$localeUrls',
            $content,
            'navbar must use $localeUrls array for all locale links'
        );
        $this->assertStringContainsString(
            'foreach',
            $content,
            'navbar must iterate over localeUrls'
        );
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

    public function testNavbarUsesLocaleUrls(): void
    {
        $navbarFile = APPPATH . 'Views/layouts/navbar.php';
        $this->assertFileExists($navbarFile);
        $content = file_get_contents($navbarFile);
        $this->assertStringContainsString(
            '$localeUrls',
            $content,
            'navbar.php must use $localeUrls for locale links'
        );
    }

    public function testNavbarNoLtrimServiceUri(): void
    {
        $navbarFile = APPPATH . 'Views/layouts/navbar.php';
        $this->assertFileExists($navbarFile);
        $content = file_get_contents($navbarFile);
        $this->assertStringNotContainsString(
            "ltrim(service('uri')->getPath()",
            $content,
            'navbar.php must not use ltrim(service(\'uri\')->getPath())'
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

    public function testTentangRouteExists(): void
    {
        $routesFile = APPPATH . 'Config/Routes.php';
        $this->assertFileExists($routesFile);
        $content = file_get_contents($routesFile);
        $this->assertStringContainsString(
            "\$routes->get('tentang', 'Home::page/about')",
            $content,
            'Routes.php must have tentative route for about page'
        );
    }

    public function testRenderPagesCommandDoesNotExist(): void
    {
        $commandFile = APPPATH . 'Commands/RenderPages.php';
        $this->assertFileDoesNotExist(
            $commandFile,
            'RenderPages.php must not exist (obsolete pre-render pipeline removed)'
        );
    }

    public function testAboutSubdirectoriesDoNotExist(): void
    {
        $aboutDir = APPPATH . 'Views/pages/about/';
        $this->assertDirectoryDoesNotExist(
            $aboutDir,
            'app/Views/pages/about/ subdirectories must not exist'
        );
    }

    public function testComposerPostInstallOnlyDesignSync(): void
    {
        $composerFile = ROOTPATH . 'composer.json';
        $this->assertFileExists($composerFile);
        $content = file_get_contents($composerFile);
        $this->assertStringContainsString('"php spark design:sync"', $content);
        $this->assertStringNotContainsString('render:pages', $content);
    }
}
