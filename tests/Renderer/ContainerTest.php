<?php

declare(strict_types=1);

namespace Engraving\Test\Unit\Container;

use Engraving\Container\Container;
use Engraving\Container\Factory\InvokableFactory;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    /**
     * @covers \Engraving\Container\Container::__construct
     * @covers \Engraving\Container\Container::get
     */
    public function testCanGetFactoryCreatedDependencies(): void
    {
        $config = [
            'dependencies' => [
                'factories' => [
                    \stdClass::class => InvokableFactory::class,
                ]
            ]
        ];

        $container = new Container($config);

        $object = $container->get(\stdClass::class);
        $this->assertInstanceOf(\stdClass::class, $object);
    }
}
