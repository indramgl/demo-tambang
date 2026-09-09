<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class LocaleConfigTest extends CIUnitTestCase
{
    public function testFiltersAliasLocaleExists(): void
    {
        $filters = new \Config\Filters();

        $this->assertArrayHasKey('locale', $filters->aliases);
        $this->assertSame(\App\Filters\Locale::class, $filters->aliases['locale']);
    }

    public function testAppSupportedLocalesHasAllSix(): void
    {
        $app = new \Config\App();

        $this->assertSame(['id', 'en', 'zh', 'fr', 'es', 'ja'], $app->supportedLocales);
    }

    public function testAppDefaultLocaleRemainsEn(): void
    {
        $app = new \Config\App();

        $this->assertSame('en', $app->defaultLocale);
    }
}
