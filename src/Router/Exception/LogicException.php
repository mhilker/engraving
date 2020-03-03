<?php

declare(strict_types=1);

namespace Engraving\Router\FastRoute\Exception;

use Engraving\Router\Exception\RouterException;
use Exception;

final class LogicException extends Exception implements RouterException
{

}
