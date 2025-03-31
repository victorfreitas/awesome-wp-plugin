<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Loggers;

enum Level: int
{
    case Debug = \Monolog\Level::Debug->value;
    case Info = \Monolog\Level::Info->value;
    case Notice = \Monolog\Level::Notice->value;
    case Warning = \Monolog\Level::Warning->value;
    case Error = \Monolog\Level::Error->value;
    case Critical = \Monolog\Level::Critical->value;
    case Alert = \Monolog\Level::Alert->value;
    case Emergency = \Monolog\Level::Emergency->value;
}
