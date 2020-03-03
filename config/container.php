<?php

declare(strict_types=1);

use Engraving\Container\Container;

$config = require __DIR__ . '/config.php';

$container = new Container($config);
$container->set('config', $config);
return $container;
