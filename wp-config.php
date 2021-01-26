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
define( 'DB_NAME', 'jobscourz3es' );


/** MySQL database username */
//define( 'DB_USER', 'root' );
define( 'DB_USER', 'czzsjbzz' );
// czzsjbzz

/** MySQL database password */
//define( 'DB_PASSWORD', 'mysql' );
define( 'DB_PASSWORD', 'cuzzsjbz66' );
// cuzzsjbz66

/** MySQL hostname */
//define( 'DB_HOST', 'localhost' );
define( 'DB_HOST', 'mysql.coursesandjobs.redballoonweb.com' );
// mysql.coursesandjobs.redballoonweb.com

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
define( 'AUTH_KEY',         'k+Lh8Y2A!GTQlQppn 0`s#H3HT};$~r Um&U|OcSJ^-;j1BV`12;OE@(y3_Zec]S' );
define( 'SECURE_AUTH_KEY',  '<L4{3Mo@)WW L`@aLZjE/*hW_m-vxwT]ksfsu5z0+:hRG(1;rmP[S?<k5~7/}M x' );
define( 'LOGGED_IN_KEY',    '_*fj_QB6sjBwLuFDfj@(23lPYW>Rc!~U d$*VDo>&RBsYv2(T];P;}MV(Fh,j!8^' );
define( 'NONCE_KEY',        '%SX)x1XH<VzZMZ(I&~UbBF~#ujhI)3aFL Q u#`e1GP]8z_[O6AfjL% KZ]cZ_!#' );
define( 'AUTH_SALT',        'LC H/]LAKY6&FZm]duf,?c430}_UFp^#d<SvBmRjJ6W{-(7=i/l-f8dNm3CuFX4]' );
define( 'SECURE_AUTH_SALT', 'hjfVF}gg=T_f:2U> ud c`;*![F#)B!r _=o^gJ}E$Zb_[&9zE2$7^1SuQOi$:4S' );
define( 'LOGGED_IN_SALT',   'XF7|]dE=23uB`VV&vamY*oR{+7^@k-@C Fp@1-=OZ/U+FWx{aGAI-I^O!9z(cE5{' );
define( 'NONCE_SALT',       'Ivr=%nurgr@x;=c8L.#=m;^0i4C$HPWJ}~he+AK{h:iU6H1*[i}-Y1~//j^G~d?v' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'cja_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
