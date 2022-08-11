<?php

/**
 * Fired during plugin activation
 *
 * @link       https://sparkweb.com.au/
 * @since      1.0.0
 *
 * @package    Spark_Risk_Watch_Rss
 * @subpackage Spark_Risk_Watch_Rss/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Spark_Risk_Watch_Rss
 * @subpackage Spark_Risk_Watch_Rss/includes
 * @author     Spark Web Solutions <solutions@sparkweb.com.au>
 */
class Spark_Risk_Watch_Rss_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		flush_rewrite_rules();
	}

}
