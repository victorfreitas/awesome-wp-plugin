<?php

declare(strict_types=1);

namespace Awesome;

defined('ABSPATH') || exit;

\add_action(
    'admin_notices',
    static function () {
		// phpcs:disable Generic.Files.InlineHTML.Found
        ?>
    <div class="notice notice-error is-dismissible">
        <p>
            <?php
            \printf(
                /* translators: %s: PHP version */
                \esc_html__(
                    'Awesome requires PHP %s or greater. Please upgrade your PHP version.',
                    'awesome'
                ),
                esc_html(PLUGIN_AWESOME_PHP_VERSION)
            );
            ?>
        </p>
    </div>
        <?php
		// phpcs:enable Generic.Files.InlineHTML.Found
    }
);
