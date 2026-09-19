<?php

namespace Tests\Unit\Commands;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class RenderPagesTest extends CIUnitTestCase
{
    public function testRenderPagesCommandDoesNotExist(): void
    {
        $commandFile = APPPATH . 'Commands/RenderPages.php';
        $this->assertFileDoesNotExist(
            $commandFile,
            'RenderPages.php command file must not exist (removed with CI4 view rendering)'
        );
    }
}
