<?php

declare(strict_types=1);

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Parsedown;

/**
 * Pre-renders markdown content files into HTML for static page serving.
 *
 * Scans app/Views/pages/ for page directories and locale subdirectories,
 * reads each .md file, converts markdown to HTML via Parsedown,
 * and writes the rendered HTML to public/content/{page}/{locale}.html.
 *
 * Usage: php spark render:pages
 */
class RenderPages extends BaseCommand
{
    protected $group = 'Render';

    protected $name = 'render:pages';

    protected $description = 'Pre-renders markdown content files into HTML for static page serving';

    protected $usage = 'render:pages';

    public function run(array $params)
    {
        $pagesDir = dirname(FCPATH) . '/app/Views/pages';
        $outputDir = FCPATH . 'content';

        if (! is_dir($pagesDir)) {
            CLI::error('Pages directory not found: ' . $pagesDir);

            return EXIT_ERROR;
        }

        $parsedown = new Parsedown();
        $locales = ['ID', 'EN', 'ZH', 'FR', 'ES', 'JA'];
        $rendered = 0;

        $pageDirs = glob($pagesDir . '/*', GLOB_ONLYDIR);

        foreach ($pageDirs as $pageDir) {
            $pageName = basename($pageDir);

            foreach ($locales as $locale) {
                $localeDir = $pageDir . '/' . $locale;

                if (! is_dir($localeDir)) {
                    continue;
                }

                $mdFiles = glob($localeDir . '/*.md');

                foreach ($mdFiles as $mdFile) {
                    $mdContent = file_get_contents($mdFile);
                    $htmlContent = $parsedown->text($mdContent);

                    $outputPageDir = $outputDir . '/' . $pageName;
                    if (! is_dir($outputPageDir)) {
                        mkdir($outputPageDir, 0755, true);
                    }

                    $outputFile = $outputPageDir . '/' . strtolower($locale) . '.html';
                    file_put_contents($outputFile, $htmlContent);
                    $rendered++;
                }
            }
        }

        CLI::write(CLI::color("Rendered {$rendered} pages to {$outputDir}", 'green'));

        return EXIT_SUCCESS;
    }
}
