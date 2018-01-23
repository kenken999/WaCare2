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
define('DB_NAME', 'WaCareData');

/** MySQL database username */
define('DB_USER', 'WaCare');

/** MySQL database password */
define('DB_PASSWORD', 'Wc123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'v(ay270~[;@^ck+bUqZh?#kMMcw(.}S6T[CNdm&=zl_f~M<_]r$Srq1z:o>4hgR5');
define('SECURE_AUTH_KEY',  '4Hpm5!u$=cC3DfP@2:8|GaAlIzw/19AFif5WF^Ic|^cafZ%z3<Hu#9h8y`BzfZ;F');
define('LOGGED_IN_KEY',    'CsfL00bLa70alh}qxhB0l8-fO$/1|)~|qF]Df5v$FjW:.;B%2m qm06O*=5PEO <');
define('NONCE_KEY',        '&SYRZ)34Nf461:Mo9FMt8B61nRQr0mE#=TeK:!F(2nN7#yEQ_/qw-M;A$EcNC~:l');
define('AUTH_SALT',        'Rs,&X=R8P=~f c5mxelu lT,o.ED)^EN;a8mI>b[ u;..QRpK[rwurcIG~:UAn^O');
define('SECURE_AUTH_SALT', 'q~K$E]-aZQ@]1f-rbpoyFvnG7i4FIhmUhUn3eSGfeCgPeO7WG H=vLod#(5`X9Wo');
define('LOGGED_IN_SALT',   'oC5D&`ubnxnB2$FUuNY5X70sb t3r7~nQ*whAx2G3o>V0W$@tAK`*v~`o4n8b>tQ');
define('NONCE_SALT',       'rv>s1r?6Z+7}IfjkXz<|;WeYCHrA^!#WH^p)%[5)bc)&eN _W86QZ8oF-amn)1oM');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
