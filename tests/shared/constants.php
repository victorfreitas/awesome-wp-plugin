<?php

declare(strict_types=1);

// @phpcs:ignore Inpsyde.CodeQuality.NoTopLevelDefine.Found
define('PLUGIN_ROOT_DIR', dirname(dirname(__DIR__)));
define('ABSPATH', dirname(dirname(PLUGIN_ROOT_DIR)) . '/');
define('PLUGIN_BASENAME', basename(PLUGIN_ROOT_DIR) . '/awesome.php');

const PLUGIN_FILENAME = 'awesome.php';
const PLUGIN_SLUG = 'awesome';
const PLUGIN_TITLE = 'Awesome';
const PLUGIN_FILE = PLUGIN_ROOT_DIR . '/' . PLUGIN_SLUG . '.php';
const PLUGIN_AWESOME_VERSION = '0.0.1';
const PLUGIN_AWESOME_PHP_VERSION = '8.3.0';
const PLUGIN_AWESOME_WORDPRESS_VERSION = '6.7.2';
const PLUGIN_AWESOME_MYSQL_VERSION = '8.0.0';
