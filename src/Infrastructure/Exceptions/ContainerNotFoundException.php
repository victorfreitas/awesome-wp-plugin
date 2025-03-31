<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Exceptions;

use Awesome\Domain\Interfaces\ContainerNotFoundExceptionInterface;

class ContainerNotFoundException extends \Exception implements ContainerNotFoundExceptionInterface
{
}
