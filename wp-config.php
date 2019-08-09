<?php
define( 'WP_CACHE', false );
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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "sass-herostencil" );

/** MySQL database username */
define( 'DB_USER', "chaka" );

/** MySQL database password */
define( 'DB_PASSWORD', "this.admin" );

/** MySQL hostname */
define( 'DB_HOST', "localhost" );

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** set debugging option */
define( 'WP_DEBUG', true );

/** allow svg file upload */
define( 'ALLOW_UNFILTERED_UPLOADS', true );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'GDT0rx3lmAx$z<WAHUp#OpP6`qRwqrNF<;=FEqj|hQe{RW1Vfitz/^:lt83/CM2|' );
define( 'SECURE_AUTH_KEY',   '<Y{70WIxDm^EB@xF]!~0HC$0N%>u9!N02By}~[K=O_1@h8({m-,$inVamemYhqNj' );
define( 'LOGGED_IN_KEY',     '2`7O@ew,v51SDjA46_H9D3+{*/ ~dl2RdCTtyt3?js:$e =~5UnKv.U,!ej95qS8' );
define( 'NONCE_KEY',         ')3U,7/Up^=kbunTvP)u1QIkg1V_TphO!9hps]-*p lHCqOxuVbvk(qm]JXC{-TBH' );
define( 'AUTH_SALT',         'O/j-%>{wEO;0k~E+))*5I;BJI$t[_gWHQ.k?Q:$W4[~sR&P$3~3?/]lK,p?|}u%C' );
define( 'SECURE_AUTH_SALT',  'xK^H[={W7%cCHmr[JJ!U]lbl(NM<kcxL29+PGQ(R04GteAi0/VUb%(e$G*;N3%eC' );
define( 'LOGGED_IN_SALT',    ';0coC#_wt;gNFIF*m6=fD=+%tPAZ^SmD3gf_k,QK?|/oIY)`nm3Le_>brh](xAXJ' );
define( 'NONCE_SALT',        'AS[QCRsgmz Sbo|l&[yZCJzF[6V?_o8[r8@yh7D{AU~A8s*Y7H lEY>t}HEP@al}' );
define( 'WP_CACHE_KEY_SALT', '_QAYexiUFB()%Hicd0gxQb HokAoWNK-@pv@mv)7!XR~o$>-gn/>)8J[+sOt~XIH' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';





/* That's all, stop editing! Happy blogging. */
/** Liquid Web Managed WordPress BEGIN **/
/** Warning: Only make changes to this section if you are requested by Liquid Web Managed WordPress Support. **/
/** Changes made within the BEGIN and END blocks may be removed during future platform updates. **/

/* Turn HTTPS 'on' if HTTP_X_FORWARDED_PROTO matches 'https' */
if ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
    $_SERVER['HTTPS'] = 'on';
}

/** Set Client IP based on HTTP_X_FORWARDED_FOR if provided. **/
if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
	$ip_list = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
	$_SERVER['REMOTE_ADDR'] = trim( $ip_list[0] );
}




/** Core auto updates **/
defined('WP_AUTO_UPDATE_CORE')   || define('WP_AUTO_UPDATE_CORE', 'minor');

/** Always use the direct method for file access **/
defined('FS_METHOD')             || define('FS_METHOD', 'direct');
/** Liquid Web Managed WordPress END **/

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
