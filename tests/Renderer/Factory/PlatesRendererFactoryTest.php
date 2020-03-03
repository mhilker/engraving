<?php

namespace Engraving\Test\Unit\Template\Plates\Factory\PlatesRendererFactory;

use Engraving\Template\Plates\Factory\PlatesRendererFactory;
use Engraving\Template\Plates\PlatesRenderer;
use League\Plates\Engine;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class PlatesRendererFactoryTest extends TestCase
{
    /**
     * @var PlatesRendererFactory
     */
    private $factory;

    public function setUp(): void
    {
        $this->factory = new PlatesRendererFactory();
    }

    /**
     * @covers \Engraving\Template\Plates\Factory\PlatesRendererFactory::__invoke
     * @uses \Engraving\Template\Plates\PlatesRenderer::__construct
     */
    public function testFactoryCanCreateInstanceOfPlatesRenderer(): void
    {
        $engine = $this->createMock(Engine::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())->method('get')->willReturn($engine);

        $renderer = $this->factory->__invoke($container);
        $this->assertInstanceOf(PlatesRenderer::class, $renderer);
    }
}
