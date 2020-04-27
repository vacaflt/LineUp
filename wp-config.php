<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
$connectstr_dbhost = 'localhost';
$connectstr_dbname = 'local';
$connectstr_dbusername = 'root';
$connectstr_dbpassword = 'root';

foreach ($_SERVER as $key => $value) {
	if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
		continue;
	}
	$connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
	$connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
	$connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
	$connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', $connectstr_dbname );

/** MySQL database username */
define( 'DB_USER', $connectstr_dbusername );

/** MySQL database password */
define( 'DB_PASSWORD', $connectstr_dbpassword );

/** MySQL hostname */
define( 'DB_HOST', $connectstr_dbhost );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '8oDjQ4erscilARjhhgWCd2EHZJLQAczOPsiiYCRTsvz8fnK+Dy8rms21KtoToAVzf3UwGQKEnwbIO+RGm/GxFw==');
define('SECURE_AUTH_KEY',  'kZZ1BibUz9nryGlkZXExWd6pgJfsuGpeG8iJwQ9AAZ/94/yPmaY6cZZDj0z2AZ9Bn0Bd8+N+76WDOF+VeSGZuw==');
define('LOGGED_IN_KEY',    'vb3bknJJqs9OVeX+4J0KIjl53lxbo7V++tj1tdKZe0NMK7zk9cD5DxXENjvy2/X+8snLD1rZ7WY7EIAuN7i9ZQ==');
define('NONCE_KEY',        'xPFzCSLr3V5pFnyhxdHbk/7DcbkUCRisUddfCW7/I7r0UOSXY6SaCy4hvCmWd7nMPzzEWywJGZEIHqv5BYcfWA==');
define('AUTH_SALT',        'Hr5eOnNtUeG6KZwOS+tJxzS3zkzlaCu3IqiDiTJ1S9jx7ayRBtrNlExhYCcsDnmsS/+fxMBi8Z0/mimYrVjghw==');
define('SECURE_AUTH_SALT', 'h0/izJ2yxHoyIefyJFupg8Z7+mvNXNsY5sCZnFWUQwmFkcl65f6FkjslcU3Z9Athdhe3dGURXcpyt5QPejafrg==');
define('LOGGED_IN_SALT',   'ShVc7h5JplvqmkPsi8otrnfT5/nX5n2gNLRCqH0liyaC7UXKF8hDjdIWqcN8jV121jHRovI1uZN2yqcVFQD/qA==');
define('NONCE_SALT',       'YJtw5t0sMWRRwO/4Dk63Knfr3O5irs1oxLGPALclLOcHIIsemIZUwUkEwTXf9LxbyR2ln6w9+eNUAhTUiXnDyQ==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
