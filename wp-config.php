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
define('DB_NAME', 'catazien');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         't6:^*F dG/iqr9:UvC6Jc`dOYMqgQzQ@H6aD@|@j=Yxi^Y9K${q17CI`7/C38S/r');
define('SECURE_AUTH_KEY',  'rEVOE5Gq$dX0`78QHaFKfPVl8J3qA{<Q4RFYGt@7Q5DJw6tHE}eC(-Rv=6C@`b>t');
define('LOGGED_IN_KEY',    '+ZCL1_MA1?YhcQf9.(EUE_b=KJxghj+aH;vX#dDE0x)]RfcNsW/sP+* a1/yuVRi');
define('NONCE_KEY',        '9XJSfYL}zEd)N@dqkJGz9Eja[&] kcdoFJv=j*Ho(5nH18cZ (WkhXh&.C)G_L&%');
define('AUTH_SALT',        '-%S{hI}gNM9lcLWc> |z/~$km=})MbI:u#ShflNg;B8#z5EG0Q^)TCB>:yOfFL=/');
define('SECURE_AUTH_SALT', '9{d>bg:ui@t%!<9NnTtldhzs,U6k4h#@y#.M:Y_5RkFM|[$$9zzl)%X%EHcoY:em');
define('LOGGED_IN_SALT',   'z/%gM9Y:;ADD{kc}ZO-a6qvC:>${_1xxr$`A)O%hXyld7 UUq-|,BINM0v]<3+!o');
define('NONCE_SALT',       'Kx!!2lmG GHX?r%|Y+E`^IiE@*uW6d]fT4c$`Za2I<P|~7WnjI7SE8HtOyS!-7q]');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'cm_';

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
