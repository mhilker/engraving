<?php

declare(strict_types=1);

use App\AppConfigProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

$cacheFile = __DIR__ . '/../cache/config.cache.php';
$autoload  = __DIR__ . '/autoload/*.php';

$aggregator = new ConfigAggregator([
    new PhpFileProvider($autoload),
    AppConfigProvider::class,
], $cacheFile);

return $aggregator->getMergedConfig();
