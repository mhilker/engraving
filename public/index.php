<?php

declare(strict_types=1);

use Engraving\Application;
use GuzzleHttp\Psr7\ServerRequest;

(static function () {
    require __DIR__ . '/../vendor/autoload.php';

    $container = require __DIR__ . '/../config/container.php';

    $request = ServerRequest::fromGlobals();

    /** @var Application $application */
    $application = $container->get(Application::class);
    $application->run($request);
})();
