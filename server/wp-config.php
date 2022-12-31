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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp-server' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '3PvK-bQ0NH%qQ.[4eCA$16s#J~! :NWiB08Fnp^a{>Z{$93&$d.p=*]6ZtP&wYtP' );
define( 'SECURE_AUTH_KEY',  'zl@A)hiLPF2F<t~:=[]1u6x7uJ98hT)G!1=VL,-1qXYr$A./EnoBkPIL/5SX#j_C' );
define( 'LOGGED_IN_KEY',    'vy_2h&RenpRC;l&!y#vZq)[-$EFe@OXPIpv3}fQrX^y@EvTP!e43$uTM=nT3eBNv' );
define( 'NONCE_KEY',        'L%VCF`YJfNNB34[lRVjEi_td=ZB^EvA1}QNXUZE8u/+}+e7.v]%KIbaA/V#uBv>2' );
define( 'AUTH_SALT',        '|^$>_b&nj)VuZ[+DxZj58()l:&#G1TU=$0zi/<!wrxz:+.}3>KGBd+6<_k+TV`7-' );
define( 'SECURE_AUTH_SALT', 'd(+49W/x8Lp.Hr4]LSz+M`9?p6;gl`y)kI6/6H(L8JbfE)8oom=BgYomTXQ[UQf%' );
define( 'LOGGED_IN_SALT',   'EbUstW(X`1}`A29qHzv=f0{eVIo(lo(l`r?VC1VmB2fK2<XZ%8>`K_f3~dF/?*JT' );
define( 'NONCE_SALT',       '?ZV!ia(!jzi5A6V6GBR%Hx2Ua=N(5z 6*ZuaF,6Ws$liWna<o(pKVbY8/m[MlX1n' );

define('JWT_AUTH_SECRET_KEY', '-[<bE4_wI-%m*KBcKxA5C<:cI2*a,&*44CSd[c-PO>6&6qj)OJ3P,E5}Y=|Oi|gq');
define('JWT_AUTH_CORS_ENABLE', true);

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
