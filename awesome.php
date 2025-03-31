<?php

/**
 * Awesome
 *
 * @package Awesome
 * @since   1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Awesome
 * Plugin URI:        https://github.com/victorfreitas/awesome-wp-plugin
 * Description:       An awesome plugin for WordPress.
 * Version:           0.0.1
 * Author:            Victor Freitas
 * Author URI:        https://github.com/victorfreitas
 * Text Domain:       awesome
 * Domain Path:       /i18n/languages
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Update URI:        https://github.com/victorfreitas/awesome-wp-plugin
 * Requires at least: 6.7.2
 * Requires PHP:      8.3.0
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

const PLUGIN_AWESOME_PHP_VERSION = '8.3.0';

if (\version_compare(PHP_VERSION, PLUGIN_AWESOME_PHP_VERSION, '<')) {
    require_once __DIR__ . '/requirements/php-version-notice.php';
    return;
}

const PLUGIN_AWESOME_VERSION = '0.0.1';
const PLUGIN_AWESOME_WORDPRESS_VERSION = '6.7.2';
const PLUGIN_AWESOME_MYSQL_VERSION = '8.0.0';

if (\is_readable(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';

    Awesome\Application\Kernel::boot(context: ['plugin.file' => __FILE__]);
}
