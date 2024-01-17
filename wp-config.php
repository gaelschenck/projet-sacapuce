<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sacapuce' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'MZuMt^W&6O;dsFJnEolEE-(%Vp2,b L`t[pt4zT6/I=s)zr)u*<571Qzu)NK p+P' );
define( 'SECURE_AUTH_KEY',  'Sb~,%Og;xhT=eOJ]]oa9qH,a%5; x[# 2,3O.*sxw5$<:JFV6?Z< O[6wuISS3[)' );
define( 'LOGGED_IN_KEY',    'S5Wvbv<?n|x9&_,wvQf:A_L4Yi`h#c9CR,G^D@14,tH1I5=>iU4n%,A=TyhX*vL|' );
define( 'NONCE_KEY',        'fys*5r);.k*rq`$M~S29b.T|`-4GJ[~cg=r|oK#SDWu0fY.Y)M2%QNdrRm//!Tbm' );
define( 'AUTH_SALT',        'y94;a@Q`S  ~Ldo>n@CtCS+hiA$BfVtyKl1}zy!7<=WQpEAFa<.1:x?+=4!a^|%t' );
define( 'SECURE_AUTH_SALT', '$F19dJ#uHt{W[ftpQb,es07K5%)VfafjuLb h^EfZON{lWt.+20/3Q|}2jmd@C?&' );
define( 'LOGGED_IN_SALT',   '6d4hBH9XVhh%qKPjFfz;At1jQIscc6sj$kNsI7Xi_WAhJ?O(t ZvFyr*9Z4L2f!6' );
define( 'NONCE_SALT',       'jWHP?pu@-&YUxnl(/pbgLdl#y!fz4suZ8{^fV^LVn:K2-?y-0<es3BW%P+L-aaWP' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
