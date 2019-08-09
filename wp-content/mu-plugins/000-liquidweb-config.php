<?php 
/**
 * Plugin Name: Liquid Web Managed WordPress Configuration
 * Plugin URI:  https://www.liquidweb.com
 * Description: Configuration to support the Liquid Web Managed WordPress and WooCommerce platforms.
 * Author:      Liquid Web
 * Author URI:  https://www.liquidweb.com
 * Text Domain: liquid-web-mwp
 * Domain Path: /languages
 * Version:     1.0.0
 *
 * @package LiquidWeb\MWP\Config
 * @author  Liquid Web
 */

/** LW specific constants **/
define( 'LWMWP_SITE', true );
define( 'LWMWP_PLAN_NAME', 'Agency: Up to 50 Sites' );
defined( 'LWMWP_SITE_ENDPOINT' ) || define('LWMWP_SITE_ENDPOINT', 'https://app.m0hm55r2-liquidwebsites.com/api/sites/1/');
defined( 'LWMWP_API_TOKEN' )     || define('LWMWP_API_TOKEN',     '85e5ff49-0903-48ef-ade6-e7e99fc2147e');

/** Fail2Ban **/
defined('WP_FAIL2BAN_BLOCK_USER_ENUMERATION') || define('WP_FAIL2BAN_BLOCK_USER_ENUMERATION', true);
