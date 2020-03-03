<?php

declare(strict_types=1);

namespace App\Test\Action;

use App\Action\IndexAction;
use Engraving\Template\RendererInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexActionTest extends TestCase
{
    /**
     * @var IndexAction
     */
    private $action;

    /**
     * @var RendererInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $renderer;

    public function setUp(): void
    {
        $this->renderer = $this->createMock(RendererInterface::class);

        $this->action = new IndexAction($this->renderer);
    }

    /**
     * @throws \Engraving\Template\Exception\RendererException
     * @throws \ReflectionException
     */
    public function testCanReturnResponse(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);

        $response = $this->action->handle($request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
