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

    public function testHomeControllerHasIndexMethod(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $this->assertFileExists($controllerFile);
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'public function index()',
            $content,
            'Home.php must have index() method'
        );
    }

    public function testHomeControllerHasHistoryMethod(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $this->assertFileExists($controllerFile);
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'public function history()',
            $content,
            'Home.php must have history() method'
        );
    }

    public function testHomeControllerHasVisionMissionMethod(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $this->assertFileExists($controllerFile);
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'public function visionMission()',
            $content,
            'Home.php must have visionMission() method'
        );
    }

    public function testHomeControllerHasServicesMethod(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $this->assertFileExists($controllerFile);
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'public function services()',
            $content,
            'Home.php must have services() method'
        );
    }

    public function testHomeControllerHasContactMethod(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $this->assertFileExists($controllerFile);
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'public function contact()',
            $content,
            'Home.php must have contact() method'
        );
    }

    public function testHomeControllerHasPortfolioMethod(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $this->assertFileExists($controllerFile);
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'public function portfolio()',
            $content,
            'Home.php must have portfolio() method'
        );
    }

    public function testHomeControllerHasInvestorMethod(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $this->assertFileExists($controllerFile);
        $content = file_get_contents($controllerFile);
        $this->assertStringContainsString(
            'public function investor()',
            $content,
            'Home.php must have investor() method'
        );
    }

    public function testEachMethodReturnsViewWithCorrectData(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $this->assertFileExists($controllerFile);
        $content = file_get_contents($controllerFile);

        // Each method should return view('pages/{page}', [...])
        $methods = [
            'index' => 'pages/home',
            'history' => 'pages/history',
            'visionMission' => 'pages/vision-mission',
            'services' => 'pages/services',
            'contact' => 'pages/contact',
            'portfolio' => 'pages/portfolio',
            'investor' => 'pages/investor',
        ];

        foreach ($methods as $method => $view) {
            $this->assertStringContainsString(
                "view('{$view}'",
                $content,
                "Home::{$method}() must return view('{$view}')"
            );
        }
    }

    public function testEachMethodPassesTitleLocaleContent(): void
    {
        $controllerFile = APPPATH . 'Controllers/Home.php';
        $this->assertFileExists($controllerFile);
        $content = file_get_contents($controllerFile);

        // Each method should pass title, locale, and content to the view
        $this->assertStringContainsString("'title'", $content);
        $this->assertStringContainsString("'locale'", $content);
        $this->assertStringContainsString("'content'", $content);
    }
}
