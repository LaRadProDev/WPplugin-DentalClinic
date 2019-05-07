<?php

use PassThisTest\PassThisTest;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           PassThisTest
 *
 * @wordpress-plugin
 * Plugin Name:       PassThisTest
 * Plugin URI:        
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mark P
 * Author URI:        https://www.upwork.com/freelancers/~01fae4b5e350089d60
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       PassThisTest
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once __DIR__ . '/vendor/autoload.php';

define( 'PassThisTest_VERSION', '1.0.0' );
define( 'PassThisTest_MAIN_FILE_NAME', 'pass_this_test' );

PassThisTest::run();