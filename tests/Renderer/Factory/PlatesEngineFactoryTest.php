<?php

namespace Engraving\Test\Unit\Template\Plates\Factory\PlatesEngineFactory;

use Engraving\Template\Plates\Factory\PlatesEngineFactory;
use League\Plates\Engine;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class PlatesEngineFactoryTest extends TestCase
{
    /**
     * @var PlatesEngineFactory
     */
    private $factory;

    public function setUp(): void
    {
        $this->factory = new PlatesEngineFactory();
    }

    /**
     * @covers \Engraving\Template\Plates\Factory\PlatesEngineFactory::__invoke
     */
    public function testFactoryCanCreateInstanceOfPlatesEngine(): void
    {
        $config = [];

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())->method('get')->willReturn($config);

        $engine = $this->factory->__invoke($container);
        $this->assertInstanceOf(Engine::class, $engine);
    }

    /**
     * @covers \Engraving\Template\Plates\Factory\PlatesEngineFactory::__invoke
     */
    public function testFactoryAddsFileExtension(): void
    {
        $config = [
            'renderer' => [
                'plates' => [
                    'fileExtension' => 'phtml'
                ],
            ]
        ];

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())->method('get')->willReturn($config);

        $engine = $this->factory->__invoke($container);
        $this->assertEquals('phtml', $engine->getFileExtension());
    }

    /**
     * @covers \Engraving\Template\Plates\Factory\PlatesEngineFactory::__invoke
     */
    public function testFactoryAddsFolders(): void
    {
        $config = [
            'renderer' => [
                'templates' => [
                    [
                        'name'      => 'foo',
                        'directory' => __DIR__ . '/foo'
                    ],
                    [
                        'name'      => 'bar',
                        'directory' => __DIR__ . '/bar'
                    ]
                ]
            ]
        ];

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())->method('get')->willReturn($config);

        $engine = $this->factory->__invoke($container);
        $folders = $engine->getFolders();
        $this->assertTrue($folders->exists('foo'));
        $this->assertTrue($folders->exists('bar'));
    }
}
