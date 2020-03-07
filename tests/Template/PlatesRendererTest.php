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
        $platesEngine = new Engine(__DIR__ . '/_files/', 'phtml');

        $renderer = new PlatesRenderer($platesEngine);
        $result = $renderer->render('template', ['foo' => 'bar']);

        $this->assertXmlStringEqualsXmlString('<b>bar</b>', $result);
    }
}
