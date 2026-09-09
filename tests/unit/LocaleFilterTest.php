<?php

use App\Filters\Locale;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class LocaleFilterTest extends CIUnitTestCase
{
    public function testLocaleFilterClassExists(): void
    {
        $this->assertTrue(class_exists(Locale::class));
    }

    public function testLocaleFilterImplementsFilterInterface(): void
    {
        $filter = new Locale();

        $this->assertInstanceOf(FilterInterface::class, $filter);
    }

    public function testBeforeRedirectsInvalidLocaleToId(): void
    {
        $filter = new Locale();

        $userAgent = new UserAgent(new \Config\UserAgents());

        $request = new IncomingRequest(
            new \Config\App(),
            new URI('http://localhost:8080/xx'),
            'php://input',
            $userAgent
        );

        $result = $filter->before($request);

        $this->assertNotNull($result);
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testBeforeSetsLocaleForValidLocale(): void
    {
        $filter = new Locale();

        $userAgent = new UserAgent(new \Config\UserAgents());

        $request = new IncomingRequest(
            new \Config\App(),
            new URI('http://localhost:8080/en'),
            'php://input',
            $userAgent
        );

        $result = $filter->before($request);

        $this->assertNull($result);
        $this->assertSame('en', $request->getLocale());
    }

    public function testAfterMethodExists(): void
    {
        $filter = new Locale();

        $request  = $this->createMock(RequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $result = $filter->after($request, $response);

        $this->assertNull($result);
    }
}
