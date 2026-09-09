<?php

declare(strict_types=1);

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Syncs design tokens from design.md into public/assets/css/tokens.css.
 *
 * Reads the CSS :root block from section 1 (Design Tokens) of design.md,
 * including color tokens from 1.1, space tokens from 1.3, and radius
 * tokens from 1.4, and writes them to public/assets/css/tokens.css.
 */
class DesignSync extends BaseCommand
{
    protected $group = 'Design';

    protected $name = 'design:sync';

    protected $description = 'Syncs design tokens from design.md into public/assets/css/tokens.css';

    protected $usage = 'design:sync';

    public function run(array $params)
    {
        $designMd = dirname(FCPATH) . '/design.md';

        if (! is_file($designMd)) {
            CLI::error('design.md not found at project root.');

            return EXIT_ERROR;
        }

        $content = file_get_contents($designMd);
        $rootBlock = $this->extractRootBlock($content);

        if ($rootBlock === null) {
            CLI::error('Could not find :root block in design.md section 1.');

            return EXIT_ERROR;
        }

        $targetDir = FCPATH . 'assets/css';
        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $targetFile = $targetDir . '/tokens.css';
        file_put_contents($targetFile, $rootBlock . "\n");

        CLI::write(CLI::color('tokens.css generated successfully.', 'green'));

        return EXIT_SUCCESS;
    }

    /**
     * Extracts all CSS custom properties from Design Tokens section 1
     * and combines them into a single :root block.
     */
    private function extractRootBlock(string $content): ?string
    {
        $properties = [];

        // 1. Extract :root block from section 1.1 (Warna)
        $rootBlock = $this->extractCssRootBlock($content);
        if ($rootBlock !== null) {
            $properties = array_merge($properties, $this->extractCustomProperties($rootBlock));
        }

        // 2. Extract space tokens from section 1.3 (Spasi)
        $spaceProps = $this->extractTableTokens($content, '1.3', '/^--space-\d+/');
        $properties = array_merge($properties, $spaceProps);

        // 3. Extract radius tokens from section 1.4 (Border Radius)
        $radiusProps = $this->extractTableTokens($content, '1.4', '/^--radius-/');
        $properties = array_merge($properties, $radiusProps);

        if (empty($properties)) {
            return null;
        }

        // Build the :root block
        $lines = [];
        foreach ($properties as $name => $value) {
            $lines[] = "  {$name}: {$value};";
        }

        return ":root {\n" . implode("\n", $lines) . "\n}";
    }

    /**
     * Extracts the CSS :root { ... } block from section 1.1 of design.md.
     */
    private function extractCssRootBlock(string $content): ?string
    {
        $pattern = '/###\s*1\.1\s+Warna\s*\n\s*```css\s*\n(:root\s*\{[^}]+\})\s*\n```/s';

        if (preg_match($pattern, $content, $matches)) {
            return $matches[1];
        }

        // Fallback: try to find any :root block in the file
        $fallback = '/:root\s*\{[^}]+\}/s';
        if (preg_match($fallback, $content, $matches)) {
            return $matches[0];
        }

        return null;
    }

    /**
     * Extracts CSS custom properties from a CSS block.
     *
     * @return array<string, string> Map of property name to value
     */
    private function extractCustomProperties(string $cssBlock): array
    {
        $properties = [];
        preg_match_all('/--[\w-]+\s*:\s*[^;]+;/', $cssBlock, $matches);

        foreach ($matches[0] as $match) {
            $match = trim($match, " \t;");
            if (strpos($match, ':') !== false) {
                [$name, $value] = explode(':', $match, 2);
                $properties[trim($name)] = trim($value);
            }
        }

        return $properties;
    }

    /**
     * Extracts token name/value pairs from a markdown table in a given section.
     *
     * @param string $content   Full design.md content
     * @param string $section   Section number (e.g., "1.3")
     * @param string $propRegex Regex to match property names
     *
     * @return array<string, string> Map of property name to value
     */
    private function extractTableTokens(string $content, string $section, string $propRegex): array
    {
        $properties = [];

        // Find the section heading
        $sectionPattern = '/###\s*' . preg_quote($section, '/') . '\s+.*?\n(.*?)(?=\n###|\n---|$)/s';
        if (! preg_match($sectionPattern, $content, $sectionMatch)) {
            return $properties;
        }

        $sectionContent = $sectionMatch[1];

        // Parse markdown table rows (skip header and separator rows)
        $lines = explode("\n", $sectionContent);
        foreach ($lines as $line) {
            $line = trim($line);
            // Skip empty lines, header rows, separator rows, and non-table rows
            if ($line === '' || strpos($line, '|') === false) {
                continue;
            }
            if (preg_match('/^[\|\s\-:]+$/', $line)) {
                continue;
            }

            $cells = array_values(array_filter(array_map('trim', explode('|', $line))));
            // Filter out empty cells from leading/trailing pipes

            if (count($cells) >= 2) {
                $tokenName = $cells[0];
                $tokenValue = $cells[1];

                $tokenName = str_replace('`', '', $tokenName);
                if (preg_match($propRegex, $tokenName)) {
                    // Convert markdown bold/italic markers
                    $tokenValue = str_replace(['**', '*'], '', $tokenValue);
                    $properties[$tokenName] = $tokenValue;
                }
            }
        }

        return $properties;
    }
}
