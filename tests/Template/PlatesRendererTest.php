<?php

namespace Engraving\Template;

use League\Plates\Engine;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Engraving\Template\PlatesRenderer
 */
final class PlatesRendererTest extends TestCase
{
    public function testRenderTemplateWithPathAndVariables(): void
    {
        $filename = 'foofile';
        $variables = ['foo' => 'bar'];
        $rendered = '<b>result</b>';

        $platesEngine = $this->createMock(Engine::class);
        $platesEngine->expects($this->once())
            ->method('render')
            ->with($filename, $variables)
            ->willReturn($rendered);

        $renderer = new PlatesRenderer($platesEngine);
        $result = $renderer->render($filename, $variables);

        $this->assertEquals($rendered, $result);
    }
}
