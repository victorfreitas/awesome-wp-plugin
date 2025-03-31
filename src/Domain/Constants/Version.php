<?php

declare(strict_types=1);

namespace Awesome\Domain\Constants;

final class Version
{
    public const string PHP = \PLUGIN_AWESOME_PHP_VERSION;
    public const string PLUGIN = \PLUGIN_AWESOME_VERSION;
    public const string WORDPRESS = \PLUGIN_AWESOME_WORDPRESS_VERSION;
    public const string MYSQL = \PLUGIN_AWESOME_MYSQL_VERSION;
}
