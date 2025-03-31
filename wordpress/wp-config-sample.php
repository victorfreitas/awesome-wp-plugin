<?php

// Database
const DB_NAME = 'wp';
const DB_USER = 'wp';
const DB_PASSWORD = 'wp';
const DB_HOST = 'wp_db';
const DB_CHARSET = 'utf8mb4';
const DB_COLLATE = '';
const WP_TABLE_PREFIX = 'wp_';

// File system
const FS_METHOD = 'direct';
const DISALLOW_FILE_EDIT = false;
const DISALLOW_FILE_MODS = false;
const FS_CHMOD_DIR = 0755;
const FS_CHMOD_FILE = 0644;

// Site options
const WP_SITEURL = 'https://wp.dev';
const WP_HOME = WP_SITEURL;

// Debug options
const WP_DEBUG = true;
const WP_DEBUG_LOG = true;
const WP_DEBUG_DISPLAY = false;
const SCRIPT_DEBUG = true;

// Script options
const CONCATENATE_SCRIPTS = false;
const COMPRESS_SCRIPTS = false;
const COMPRESS_CSS = false;

// Environment
const WP_ENVIRONMENT_TYPE = 'development';

// Post revisions
const WP_POST_REVISIONS = 1;

// Memory limit
const WP_MEMORY_LIMIT = '64M';
const WP_MAX_MEMORY_LIMIT = '128M';

// Query debug
const SAVEQUERIES = true;

// Disable trash
const EMPTY_TRASH_DAYS = 0;

// SSL
const FORCE_SSL_ADMIN = true;

/**
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 */
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );

// Error handling
@ini_set('log_errors', 'On');
@ini_set('display_errors', 'Off');
@ini_set('error_reporting', E_ALL);

// Table prefix
$table_prefix = WP_TABLE_PREFIX;

// Enable SSL
$_SERVER['HTTPS'] = 'on';

require_once ABSPATH . 'wp-settings.php';
