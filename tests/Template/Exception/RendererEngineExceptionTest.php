<?php

declare(strict_types=1);

namespace Engraving\Template\Exception;

use PHPUnit\Framework\TestCase;

final class RendererEngineExceptionTest extends TestCase
{
    public function testCanFormatExceptionMessage(): void
    {
        $this->expectException(RendererEngineException::class);
        $this->expectExceptionMessage('Error during rendering of template "template-name".');

        $previous = new \Exception();
        throw RendererEngineException::withPrevious('template-name', $previous);
    }
}
