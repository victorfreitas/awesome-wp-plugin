<?php

/**
 * Database queries config.
 *
 * @package    Awesome
 * @subpackage config
 * @since      1.0.0
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Create the awesome table.
 *
 * @var \wpdb
 */
global $wpdb;

return <<<SQL
CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}awesome` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`type` ENUM('transactional', 'promotional', 'notification') NOT NULL,
	`to` VARCHAR(150) NOT NULL,
	`subject` VARCHAR(150) NOT NULL,
	`message` LONGTEXT NOT NULL,
	`headers` JSON NOT NULL,
	`attachments` JSON DEFAULT NULL,
	`status` ENUM('sent', 'failed', 'queued') NOT NULL,
	`error` JSON DEFAULT NULL,
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	KEY `type_status_idx` (`type`, `status`),
	KEY `created_at_idx` (`created_at`)
) ENGINE=InnoDB {$wpdb->get_charset_collate()};
SQL;
