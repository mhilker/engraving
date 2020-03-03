<?php

declare(strict_types=1);

use Engraving\Util\Env;
use Zend\ConfigAggregator\ConfigAggregator;

return [
    ConfigAggregator::ENABLE_CACHE => Env::bool('CACHE_ENABLED', false)
];
