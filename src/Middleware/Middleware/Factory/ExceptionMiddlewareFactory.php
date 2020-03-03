<?php
declare(strict_types=1);

namespace Engraving\Middleware\Middleware\Factory;

use Engraving\Middleware\Middleware\ExceptionMiddleware;
use Psr\Container\ContainerInterface;

class ExceptionMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return ExceptionMiddleware
     */
    public function __invoke(ContainerInterface $container): ExceptionMiddleware
    {
        $exceptionAction = $container->get(ExceptionMiddleware::EXCEPTION_ACTION);

        return new ExceptionMiddleware($exceptionAction);
    }
}
