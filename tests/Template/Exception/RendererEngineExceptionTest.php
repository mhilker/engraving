<?php

declare(strict_types=1);

namespace Engraving\Test\Unit\Template;

use Engraving\Template\Exception\RendererEngineException;
use PHPUnit\Framework\TestCase;

class RendererEngineExceptionTest extends TestCase
{
    public function testCanFormatExceptionMessage(): void
    {
        $this->expectException(RendererEngineException::class);
        $this->expectExceptionMessage('Error during rendering of template "template-name".');

        $previous = new \Exception();
        throw RendererEngineException::withPrevious('template-name', $previous);
    }
}
