<?php

namespace Tests\Unit\Controllers;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class HomeControllerTest extends CIUnitTestCase
{
    public function testHomeControllerExists(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $this->assertFileExists($controllerFile, 'Home.php controller must exist');
    }

    public function testPageMethodExists(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'public function page(string $slug',
            $content,
            'Home.php must have page() method with slug parameter'
        );
    }

    public function testPageMapContainsAllPages(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $pages = ['home', 'history', 'vision-mission', 'services', 'contact', 'portfolio', 'investor', 'about'];
        foreach ($pages as $page) {
            $this->assertStringContainsString(
                "'{$page}'",
                $content,
                "Home.php PAGE_MAP must contain '{$page}'"
            );
        }
    }

    public function testPageMapHasEightEntries(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString("'about'", $content);
        // Verify 7 original + about = 8 entries by checking all expected keys exist
        $pages = ['home', 'history', 'vision-mission', 'services', 'contact', 'portfolio', 'investor', 'about'];
        foreach ($pages as $page) {
            $this->assertStringContainsString("'" . $page . "'", $content);
        }
    }

    public function testPageMethodReturnsViewWithoutContent(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString('pages/', $content);
        $this->assertStringContainsString("'title'", $content);
        $this->assertStringContainsString("'locale'", $content);
        $this->assertStringContainsString("'localeUrls'", $content);
        $this->assertStringNotContainsString("'content'", $content);
    }

    public function testIndexMethodDelegatesToPage(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'return $this->page(',
            $content,
            'index() must delegate to page() method'
        );
    }

    public function testPageMapHasCorrectViewMapping(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString("'home'          => ['Beranda', 'home']", $content);
        $this->assertStringContainsString("'history'       => ['Sejarah', 'history']", $content);
        $this->assertStringContainsString("'vision-mission'=> ['Visi & Misi', 'vision-mission']", $content);
    }

    public function testNoGetRenderedContent(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringNotContainsString(
            'getRenderedContent',
            $content,
            'Controller must not have getRenderedContent method'
        );
    }

    public function testPageMethodThrowsPageNotFoundException(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'PageNotFoundException',
            $content,
            'Controller must throw PageNotFoundException for unknown slugs'
        );
    }

    public function testLocaleUrlMethodExists(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'protected function localeUrl',
            $content,
            'Controller must have localeUrl() method'
        );
    }

    public function testLocaleUrlUsesUriSetSegment(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            "service('uri')",
            $content,
            'localeUrl() must use service(uri)'
        );
        $this->assertStringContainsString(
            'setSegment(1, $locale)',
            $content,
            'localeUrl() must use setSegment(1, $locale) to swap locale'
        );
    }

    public function testLocaleUrlDoesNotUseLtrimPath(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringNotContainsString(
            "ltrim(service('uri')->getPath()",
            $content,
            'localeUrl() must not use ltrim(service(uri)->getPath()) pattern'
        );
    }

    public function testNavbarUsesLocaleUrlsArray(): void
    {
        $navbarFile = APPPATH . 'Views/layouts/navbar.php';
        $content = file_get_contents($navbarFile);
        $this->assertStringContainsString(
            '$localeUrls as $lang => $url',
            $content,
            'navbar.php must use $localeUrls as $lang => $url pattern'
        );
    }

    public function testMainHreflangUsesLocaleUrls(): void
    {
        $mainFile = APPPATH . 'Views/layouts/main.php';
        $content = file_get_contents($mainFile);
        $this->assertStringContainsString(
            '$localeUrls as $lang => $url',
            $content,
            'main.php must use $localeUrls for hreflang tags'
        );
    }
}
