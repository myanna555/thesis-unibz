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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'YOUR_DATABASE_NAME');

/** MySQL database username */
define('DB_USER', 'YOUR_DATABASE_USER');

/** MySQL database password */
define('DB_PASSWORD', 'YOUR_DATABASE_PASSWORD');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'AAGfK|?oIxQ|36<@bw$^i7t&`jR:f@,Et^/na1s/+:ulBa(|m[u<uJ_B}>gde`/l');
define('SECURE_AUTH_KEY',  'GjD%9hg!H#Q?})@sM:#q+]=9r_/88ZXojxx|!wX-7Jc4h)R6)b`{;St2[M!&<Y{3');
define('LOGGED_IN_KEY',    'C,aEI?fzpW@n!tRp- La#-wmQ1SS|N[u/8(J7:XoW},?vR9S[|Hr*]hbSwU+<G1<');
define('NONCE_KEY',        'c`+2(?!W*G+oRU<|TS/LJ@R!Ie-Z`14s@/wZ~A|Q<p$iYr7F+sxST7fKm^t)+Ke<');
define('AUTH_SALT',        '*2-8[HlCS!rh p+%hvB`MJe$CIUR^^T2FpZkkb^+RqmOUf]f#ID0=gQPP+OwBx>|');
define('SECURE_AUTH_SALT', '<uIK7Y_j%VOND8#NUJVNWjt.5b/$|olWO@>ZPiZH{*aT:7(!RfuRkr*V[;~d||Rv');
define('LOGGED_IN_SALT',   'z5s49mtVoSbE?0<I+5ayiP,:>B|agZj[]k=@+(x>I^~InEF5ld45cl_3||ik>[de');
define('NONCE_SALT',       '2IFI^lVk~ |s`>7Bc!V[s/4|^:dRQgz%O@<,?^I3ol`~h-{(4dkC&d%-|WtME7k&');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);
define( 'WP_MEMORY_LIMIT', '128M' );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
