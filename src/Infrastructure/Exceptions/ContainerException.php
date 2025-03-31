<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Exceptions;

use Awesome\Domain\Interfaces\ContainerNotFoundExceptionInterface;

class ContainerException extends \Exception implements ContainerNotFoundExceptionInterface
{
}
