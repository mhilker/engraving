<?php

namespace Engraving\Test\Unit\Template\Plates;

use Engraving\Template\Plates\PlatesRenderer;
use League\Plates\Engine;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

class PlatesRendererTest extends TestCase
{
    /**
     * @var PlatesRenderer
     */
    private $renderer;

    /**
     * @var Engine | PHPUnit_Framework_MockObject_MockObject
     */
    private $platesEngine;

    public function setUp(): void
    {
        $this->platesEngine = $this->createMock(Engine::class);

        $this->renderer = new PlatesRenderer($this->platesEngine);
    }

    /**
     * @covers \Engraving\Template\Plates\PlatesRenderer::__construct
     * @covers \Engraving\Template\Plates\PlatesRenderer::render
     */
    public function testRenderTemplateWithPathAndVariables(): void
    {
        $filename = 'foofile';
        $variables = ['foo' => 'bar'];
        $rendered = '<b>result</b>';

        $this->platesEngine->expects($this->once())
            ->method('render')
            ->with($filename, $variables)
            ->willReturn($rendered);

        $result = $this->renderer->render($filename, $variables);
        $this->assertEquals($rendered, $result);
    }
}
