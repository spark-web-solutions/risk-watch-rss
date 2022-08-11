<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://sparkweb.com.au/
 * @since      1.0.0
 *
 * @package    Spark_Risk_Watch_Rss
 * @subpackage Spark_Risk_Watch_Rss/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Spark_Risk_Watch_Rss
 * @subpackage Spark_Risk_Watch_Rss/includes
 * @author     Spark Web Solutions <solutions@sparkweb.com.au>
 */
class Spark_Risk_Watch_Rss_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'spark-risk-watch-rss',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
