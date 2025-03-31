<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Attributes;

use Awesome\Infrastructure\Abstracts\EventAttribute;

#[\Attribute(\Attribute::TARGET_METHOD)]
final class On extends EventAttribute
{
}
