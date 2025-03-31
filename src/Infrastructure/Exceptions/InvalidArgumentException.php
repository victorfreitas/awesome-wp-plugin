<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Exceptions;

use Awesome\Domain\Interfaces\InvalidArgumentExceptionInterface as ExceptionInterface;

class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
}
