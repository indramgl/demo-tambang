<?php

namespace Tests\Unit\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
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

    public function testPageMethodReturnsViewWithCorrectData(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString("'title' => \$title", $content);
        $this->assertStringContainsString("'locale' => \$locale", $content);
        $this->assertStringContainsString("'localeUrls' => \$localeUrls", $content);
        $this->assertStringNotContainsString("'content'", $content);
    }

    public function testPageMethodThrowsPageNotFoundForUnknownSlug(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'throw PageNotFoundException::forPageNotFound()',
            $content,
            'Controller must throw PageNotFoundException for unknown slugs'
        );
        $this->assertStringNotContainsString(
            "?? ['Beranda', 'home']",
            $content,
            'Controller must not silently fall back to home for unknown slugs'
        );
    }

    public function testPageMethodHasLocaleUrl(): void
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

    public function testPageUsesCachePage3600(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            '$this->cachePage(3600)',
            $content,
            'Home::page() must call $this->cachePage(3600) for CI4 page caching'
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
