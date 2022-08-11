<?php

/**
 * The file that defines the core plugin class
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 * @link https://sparkweb.com.au/
 * @since 1.0.0
 * @package Spark_Risk_Watch_Rss
 * @subpackage Spark_Risk_Watch_Rss/includes
 */

/**
 * The core plugin class.
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 * @since 1.0.0
 * @package Spark_Risk_Watch_Rss
 * @subpackage Spark_Risk_Watch_Rss/includes
 * @author Spark Web Solutions <solutions@sparkweb.com.au>
 */
class Spark_Risk_Watch_Rss {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 * @since 1.0.0
	 * @access protected
	 * @var Spark_Risk_Watch_Rss_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 * @since 1.0.0
	 * @access protected
	 * @var string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 * @since 1.0.0
	 * @access protected
	 * @var string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 * @since 1.0.0
	 */
	public function __construct() {
		if (defined('SPARK_RISK_WATCH_RSS_VERSION')) {
			$this->version = SPARK_RISK_WATCH_RSS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'spark-risk-watch-rss';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_ia();
	}

	/**
	 * Load the required dependencies for this plugin.
	 * Include the following files that make up the plugin:
	 * - Spark_Risk_Watch_Rss_i18n. Defines internationalization functionality.
	 * - Spark_Risk_Watch_Rss_Admin. Defines all hooks for the admin area.
	 * - Spark_Risk_Watch_Rss_Public. Defines all hooks for the public side of the site.
	 * @since 1.0.0
	 * @access private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-spark-risk-watch-rss-i18n.php';

		/**
		 * Class for simplifying creation of custom CPTs
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-spark-risk-watch-rss-cpt.php';

		/**
		 * Class for simplifying creation of custom post meta
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-spark-risk-watch-rss-meta.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-spark-risk-watch-rss-public.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-spark-risk-watch-rss-admin.php';

		/**
		 * The class responsible for handling plugin updates.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-spark-risk-watch-rss-updates.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 * Uses the Spark_Risk_Watch_Rss_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 * @since 1.0.0
	 * @access private
	 */
	private function set_locale() {
		$plugin_i18n = new Spark_Risk_Watch_Rss_i18n();

		add_action('plugins_loaded', array($plugin_i18n, 'load_plugin_textdomain'));
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 * @since 1.0.0
	 * @access private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Spark_Risk_Watch_Rss_Admin($this->get_plugin_name(), $this->get_version());

		add_action('admin_init', array($plugin_admin, 'updates'));
// 		add_action( 'admin_enqueue_scripts', array($plugin_admin, 'enqueue_styles') );
// 		add_action( 'admin_enqueue_scripts', array($plugin_admin, 'enqueue_scripts') );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 * @since 1.0.0
	 * @access private
	 */
	private function define_public_hooks() {
		$plugin_public = new Spark_Risk_Watch_Rss_Public($this->get_plugin_name(), $this->get_version());

		add_action('init', array($plugin_public, 'register_feeds'));
// 		add_action( 'wp_enqueue_scripts', array($plugin_public, 'enqueue_styles') );
// 		add_action( 'wp_enqueue_scripts', array($plugin_public, 'enqueue_scripts') );
	}

	/**
	 * Set up our custom IA
	 * @since 1.0.0
	 */
	public function define_ia() {
		$args = array(
				'public' => false,
				'show_ui' => true,
				'has_archive' => false,
				'show_in_rest' => false,
				'hierarchical' => false,
				'menu_icon' => 'dashicons-align-center',
				'supports' => array(
						'title',
						'thumbnail',
				),
		);
		new Spark_Risk_Watch_Rss_Cpt('Risk Watch Banner', 'Risk Watch Banners', $args, 'banner');

		$days_of_week = array();
		// Risk Watch only comes out on weekdays
		$date = new DateTime('Monday');
		for ($i = 1; $i <= 5; $i++) {
			$days_of_week[] = array(
					'label' => $date->format('l'),
					'value' => $i,
			);
			$date->add(new DateInterval('P1D'));
		}
		$meta_fields = array(
				array(
						'title' => __('Day of the Week', 'spark-risk-watch-rss'),
						'description' => __('If more than one banner is assigned to a given day, the feed will randomly select one.', 'spark-risk-watch-rss'),
						'field_name' => 'day_of_week',
						'type' => 'select',
						'options' => $days_of_week,
				),
				array(
						'title' => __('Link', 'spark-risk-watch-rss'),
						'field_name' => 'link',
						'type' => 'url',
				),
		);
		new Spark_Risk_Watch_Rss_Meta(__('Banner Details', 'spark-risk-watch-rss'), array('banner'), $meta_fields, 'normal');

		$ia_ver = get_option($this->plugin_name.'-version-ia', 0);
		if (version_compare($ia_ver, $this->version, '<')) {
			add_action('init', 'flush_rewrite_rules', 99);
			update_option($this->plugin_name.'-version-ia', $this->version);
		}

		// Show extra details in list
		add_filter('manage_banner_posts_columns', function ($columns) {
			$columns['Day'] = 'Day';

			return $columns;
		});

		add_action('manage_banner_posts_custom_column', function ($column_name, $post_id) {
			switch ($column_name) {
				case 'Day':
					$day_of_week = get_post_meta($post_id, 'day_of_week', true);
					echo date('l', strtotime('Sunday +'.$day_of_week.' days'));
					break;
			}
		}, 10, 2);
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 * @since 1.0.0
	 * @return string The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 * @since 1.0.0
	 * @return string The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
