<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sparkweb.com.au/
 * @since      1.0.0
 *
 * @package    Spark_Risk_Watch_Rss
 * @subpackage Spark_Risk_Watch_Rss/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Spark_Risk_Watch_Rss
 * @subpackage Spark_Risk_Watch_Rss/admin
 * @author     Spark Web Solutions <solutions@sparkweb.com.au>
 */
class Spark_Risk_Watch_Rss_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/spark-risk-watch-rss-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/spark-risk-watch-rss-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register our update handler
	 * @since 1.0.0
	 */
	public function updates() {
		new Spark_Risk_Watch_Rss_Updates(SPARK_RISK_WATCH_RSS_PATH, 'spark-web-solutions', 'risk-watch-rss');
	}

}
