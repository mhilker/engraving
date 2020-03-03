<?php

declare(strict_types=1);

namespace Engraving\Router\FastRoute\Exception;

use Engraving\Router\Exception\RouterException;

class LogicException extends \LogicException implements RouterException
{

}
