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
define('WP_HOME','https://wilopocargo.com');
define('WP_SITEURL','https://wilopocargo.com');
define( 'WP_MEMORY_LIMIT', '2560M' );
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wilopoca_wp3' );
/** MySQL database username */
define( 'DB_USER', 'wilopoca_wp3' );
/** MySQL database password */
define( 'DB_PASSWORD', 'U3pL(S5)E5' );
/** MySQL hostname */
define( 'DB_HOST', 'localhost' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'e36zsvfzssn9k5et8s26txbdg7tsrushbjv2gspyg7txxcgbrmanfn0r3582v3j8' );
define( 'SECURE_AUTH_KEY',  'ehkwn7brjn96l6jnzhnjfittxknn3jybmq3dunjtcn9ccgfajbmrnw6tqzkx6axa' );
define( 'LOGGED_IN_KEY',    'yqyxnoktxsjwesbnt59emvbblytulk4u5skv9j0klatvjtqjehtyaifwyos4rv3k' );
define( 'NONCE_KEY',        'fh3kyitkpnanhkqlon2niblvbdq7wp4typ1pdnauxvu0wyp8w5vrd8ehfkbj7wji' );
define( 'AUTH_SALT',        'py1okgzyxfw1pbetzkdm1lddh0f1ftm7fd13rgmagnprm3ea8vekjtqbx7fknha9' );
define( 'SECURE_AUTH_SALT', 'wdf24rmbu1ifaebj23eb2usx3bpodkparubwkpwelwlosja6isas3iu1makzu1g1' );
define( 'LOGGED_IN_SALT',   'urodomvbhmwikb17twl6bpdeotfniugwfm0mtgggzr8ulpcqd1nqdlpum5nnsyvc' );
define( 'NONCE_SALT',       'exolwr4ngktrqw17lojz4ycgkrpundt5ztforh3bt6hci2wnxaetuhnuogal9phd' );
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpu8_';
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );
// define( 'WP_DEBUG_DISPLAY', false );
// define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );