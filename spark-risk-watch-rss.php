<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sparkweb.com.au/
 * @since             1.0.0
 * @package           Spark_Risk_Watch_Rss
 *
 * @wordpress-plugin
 * Plugin Name:       Spark Risk Watch RSS Feeds
 * Plugin URI:        https://sparkweb.com.au/
 * Description:       Generates the custom RSS feeds required by Risk Watch
 * Version:           1.0.0-beta.1
 * Author:            Spark Web Solutions
 * Author URI:        https://sparkweb.com.au/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       spark-risk-watch-rss
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SPARK_RISK_WATCH_RSS_VERSION', '1.0.0' );
define('SPARK_RISK_WATCH_RSS_PATH', __FILE__);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-spark-risk-watch-rss-activator.php
 */
function activate_spark_risk_watch_rss() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spark-risk-watch-rss-activator.php';
	Spark_Risk_Watch_Rss_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-spark-risk-watch-rss-deactivator.php
 */
function deactivate_spark_risk_watch_rss() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spark-risk-watch-rss-deactivator.php';
	Spark_Risk_Watch_Rss_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_spark_risk_watch_rss' );
register_deactivation_hook( __FILE__, 'deactivate_spark_risk_watch_rss' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-spark-risk-watch-rss.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_spark_risk_watch_rss() {
	new Spark_Risk_Watch_Rss();
}
run_spark_risk_watch_rss();
