<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'seamorg');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '192.168.1.119');

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
define('AUTH_KEY',         'bd9|wWNZ|>!]C!ydEeYZm;@-t+^`Q]d(tn2,EY`l<z/Pek/N2Xc%tr)#s7yZQq6?');
define('SECURE_AUTH_KEY',  'C^mVppz-rzx@kL7q@|2N<)OZWAbST<!r mp`6#zbdeJHk[Z?ma!?^Dw}_=$gHFTj');
define('LOGGED_IN_KEY',    'djrib|N2J/9-1R3@1x]T5AByxn|CH(|~d!TQ_nU-g,GzF-s)&ea:MIU+VMR}ft]I');
define('NONCE_KEY',        'si/QQxF*;~@YqvN-,_V@+9oP|Dfs}%w,WM^$P|q-#NW/F$tO-9wTwZ5#~P#m,t9Z');
define('AUTH_SALT',        '{N)rkTiaODHv5-MgYyL#,:N#ef4sKGUkE7O*lV:q<YoKJ~.+=dTAwD6Wtv&I|07S');
define('SECURE_AUTH_SALT', '-1cF|X{Y@(P{t/*$<BvsL,487rhtCyB3j+2{7ypG_NDZQ)g|cuNaQzgBjl9F+|Qs');
define('LOGGED_IN_SALT',   '(14N-9Yy5CD#q|6J~h1Q.US-r!|U8jqNgs|T`Crt>L_R.skgEq/LLqu+w@T8ptsZ');
define('NONCE_SALT',       '|;=Gb.0YAdN,h-zePF9GA8s<m@q@F)4t<3gx-yce|r_hP-E$1Ij@^Ll|1ni1/LSt');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sea_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define('DBEM_CUSTOM_MAX_EVENT_LIMIT', 3);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
