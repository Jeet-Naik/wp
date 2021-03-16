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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'my_site' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Potenza@123' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'qxP=<]]c|(o<Xq yr:5,o:Omh8-zz,Jl1(a.*H:*KNmM 7}Sy,JfaZ<+a 1=3~*=' );
define( 'SECURE_AUTH_KEY',  'c(k/V1lWjl6Y~k#*ctpF4#tZn?0@<VO/dM{z2DD>#P$33$&W[DX({c~sZ%aryw0H' );
define( 'LOGGED_IN_KEY',    'OZba|~Qp!CD$4D@`tLSjis4Tu5jTg*8i$LA^:4A-zkqV31(6[cTJ>S}l}sE02(#c' );
define( 'NONCE_KEY',        ',!vI6``6%HI@D+Un!P:ikCi%$W`u7[j.#1jp{<Qvr1M^W_[Bqp3uEl^=He4~@/ti' );
define( 'AUTH_SALT',        'da_}1__P_^wFtN*V~S6lfj|)93E*~r6y8AzlXy];+v.{Z~cgYy3xC-7^n8^-t.gN' );
define( 'SECURE_AUTH_SALT', '4+rd?><6kq[xk!.aU]yh`b9G!7HOGC,j]S(@bE|-P38`;L+%EXD2$=|)TJCf<n28' );
define( 'LOGGED_IN_SALT',   'JY_K6+jAT!/bK``/[*GB<m.*$x3MG/%P8)g5]3*dW!hv088XEn`oT<EO>oz/Sp_F' );
define( 'NONCE_SALT',       'O2-MW$P]#/ud&xN~gTH5/:8|q[PZ2D8v&X+a[MQNmKO0$?[9FHWa~|S3dDrtx6}(' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
//define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
