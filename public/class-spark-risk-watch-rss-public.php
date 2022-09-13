<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://sparkweb.com.au/
 * @since      1.0.0
 *
 * @package    Spark_Risk_Watch_Rss
 * @subpackage Spark_Risk_Watch_Rss/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Spark_Risk_Watch_Rss
 * @subpackage Spark_Risk_Watch_Rss/public
 * @author     Spark Web Solutions <solutions@sparkweb.com.au>
 */
class Spark_Risk_Watch_Rss_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/spark-risk-watch-rss-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/spark-risk-watch-rss-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Register our custom RSS feed endpoints
	 * @since 1.0.0
	 */
	public function register_feeds() {
		add_feed('risk-watch/news', array($this, 'news_rss'));
		add_feed('risk-watch/people', array($this, 'people_rss'));
		add_feed('risk-watch/banners', array($this, 'banners_rss'));
	}

	/**
	 * Generate news RSS feed
	 * @since 1.0.0
	 */
	public function news_rss() {
		header('Content-type: application/rss+xml; charset=utf-8');
		header("Pragma: 0");
		header("Expires: 0");

		$now = current_time(DATE_RSS, false);
		$args = array(
				'posts_per_page' => 10,
		);
		$news = get_posts($args);

		$rss  = '<?xml version="1.0"?>'."\n";
		$rss .= '<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">'."\n";
		$rss .= '  <channel>'."\n";
		$rss .= '	<title>News</title>'."\n";
		$rss .= '	<link>'.esc_xml(site_url('/news/')).'</link>'."\n";
		$rss .= '	<description>Latest News from Rodgers Reidy</description>'."\n";
		$rss .= '	<language>en-au</language>'."\n";
		$rss .= '	<pubDate>'.$now.'</pubDate>'."\n";
		$rss .= '	<lastBuildDate>'.$now.'</lastBuildDate>'."\n";
		$rss .= '	<managingEditor>'.get_option('admin_email').'</managingEditor>'."\n";
		foreach ($news as $item) {
			$rss .= '	<item>'."\n";
			$rss .= '	  <title>'.esc_xml($item->post_title).'</title>'."\n";
			$rss .= '	  <link>'.esc_xml(get_permalink($item)).'</link>'."\n";
			$rss .= '	  <author>'.esc_xml(get_the_author_meta('display_name', $item->post_author)).'</author>'."\n";
			$rss .= '	  <description>'."\n";
			$rss .= '		<![CDATA['.$this->get_post_extract($item).']]>'."\n";
			$rss .= '	  </description>'."\n";
			$rss .= '	  <pubDate>'.get_post_datetime($item)->format(DATE_RSS).'</pubDate>'."\n";
			if (has_post_thumbnail($item)) {
				$featured_image = get_post_thumbnail_id($item);
				$image = wp_get_attachment_image_src($featured_image, array(329,246));
				$rss .= '	  <media:content url="'.$image[0].'" fileSize="'.filesize(get_attached_file($featured_image)).'" type="'.get_post_mime_type($featured_image).'" medium="image" width="'.$image[1].'" height="'.$image[2].'" />'."\n";
			}
			$cats = wp_get_post_terms($item->ID, 'category', array('fields' => 'names'));
			foreach ($cats as $cat) {
				$rss .= '	  <category>'.esc_xml($cat).'</category>'."\n";
			}
			$rss .= '	</item>'."\n";
		}
		$rss .= '  </channel>'."\n";
		$rss .= '</rss>'."\n";

		echo $rss;
	}

	/**
	 * Generate people RSS feed
	 * @since 1.0.0
	 */
	public function people_rss() {
		header('Content-type: application/rss+xml; charset=utf-8');
		header("Pragma: 0");
		header("Expires: 0");

		$now = current_time(DATE_RSS, false);
		$args = array(
				'posts_per_page' => 10,
				'post_type' => 'people',
				'orderby' => 'rand',
		);
		$news = get_posts($args);

		$rss  = '<?xml version="1.0"?>'."\n";
		$rss .= '<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">'."\n";
		$rss .= '  <channel>'."\n";
		$rss .= '	<title>Our People</title>'."\n";
		$rss .= '	<link>'.esc_xml(site_url('/people/')).'</link>'."\n";
		$rss .= '	<description>Rodgers Reidy People</description>'."\n";
		$rss .= '	<language>en-au</language>'."\n";
		$rss .= '	<pubDate>'.$now.'</pubDate>'."\n";
		$rss .= '	<lastBuildDate>'.$now.'</lastBuildDate>'."\n";
		$rss .= '	<managingEditor>'.get_option('admin_email').'</managingEditor>'."\n";
		foreach ($news as $item) {
			$rss .= '	<item>'."\n";
			$rss .= '	  <title>'.esc_xml($item->post_title).'</title>'."\n";
			$rss .= '	  <link>'.esc_xml(get_permalink($item)).'</link>'."\n";
			$rss .= '	  <author>'.esc_xml(get_the_author_meta('display_name', $item->post_author)).'</author>'."\n";
			$rss .= '	  <description>'."\n";
			$rss .= '		<![CDATA['.$this->get_post_extract($item).']]>'."\n";
			$rss .= '	  </description>'."\n";
			$rss .= '	  <pubDate>'.get_post_datetime($item)->format(DATE_RSS).'</pubDate>'."\n";
			if (has_post_thumbnail($item)) {
				$featured_image = get_post_thumbnail_id($item);
				$image = wp_get_attachment_image_src($featured_image, array(200, 200));
				$rss .= '	  <media:content url="'.$image[0].'" fileSize="'.filesize(get_attached_file($featured_image)).'" type="'.get_post_mime_type($featured_image).'" medium="image" width="'.$image[1].'" height="'.$image[2].'" />'."\n";
			}
			$rss .= '	  <category>'.esc_xml(get_post_meta($item->ID, 'office_location', true)).'</category>'."\n";
			$rss .= '	</item>'."\n";
		}
		$rss .= '  </channel>'."\n";
		$rss .= '</rss>'."\n";

		echo $rss;
	}

	/**
	 * Generate banners RSS feed
	 * @since 1.0.0
	 */
	public function banners_rss() {
		header('Content-type: application/rss+xml; charset=utf-8');
		header("Pragma: 0");
		header("Expires: 0");

		$now = current_time(DATE_RSS, false);
		$args = array(
				'posts_per_page' => 10,
				'post_type' => 'banner',
				'orderby' => 'rand',
				'meta_query' => array(
						array(
								'key' => 'day_of_week',
								'value' => current_time('w'),
						),
				),
		);
		$news = get_posts($args);

		$rss  = '<?xml version="1.0"?>'."\n";
		$rss .= '<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">'."\n";
		$rss .= '  <channel>'."\n";
		$rss .= '	<title>Banners</title>'."\n";
		$rss .= '	<link>'.esc_xml(site_url('/')).'</link>'."\n";
		$rss .= '	<description>Rodgers Reidy</description>'."\n";
		$rss .= '	<language>en-au</language>'."\n";
		$rss .= '	<pubDate>'.$now.'</pubDate>'."\n";
		$rss .= '	<lastBuildDate>'.$now.'</lastBuildDate>'."\n";
		$rss .= '	<managingEditor>'.get_option('admin_email').'</managingEditor>'."\n";
		foreach ($news as $item) {
			$rss .= '	<item>'."\n";
			$rss .= '	  <title>'.esc_xml($item->post_title).'</title>'."\n";
			$rss .= '	  <link>'.esc_xml(get_post_meta($item->ID, 'link', true)).'</link>'."\n";
			$rss .= '	  <author>'.esc_xml(get_the_author_meta('display_name', $item->post_author)).'</author>'."\n";
			$rss .= '	  <description>'."\n";
			$rss .= '		<![CDATA['.$this->get_post_extract($item).']]>'."\n";
			$rss .= '	  </description>'."\n";
			$rss .= '	  <pubDate>'.get_post_datetime($item)->format(DATE_RSS).'</pubDate>'."\n";
			if (has_post_thumbnail($item)) {
				$featured_image = get_post_thumbnail_id($item);
				$image = wp_get_attachment_image_src($featured_image, array(1200, 1200));
				$rss .= '	  <media:content url="'.$image[0].'" fileSize="'.filesize(get_attached_file($featured_image)).'" type="'.get_post_mime_type($featured_image).'" medium="image" width="'.$image[1].'" height="'.$image[2].'" />'."\n";
			}
			$rss .= '	</item>'."\n";
		}
		$rss .= '  </channel>'."\n";
		$rss .= '</rss>'."\n";

		echo $rss;
	}

	/**
	 * Generate "teaser" text from longer content
	 * @param string $content Text to generate teaser from
	 * @param integer $max_chars Optional. Default 250.
	 * @param string $suffix Optional. Default '...'.
	 * @return string Teaser text
	 * @since 1.0.0
	 */
	private function get_extract($content, $max_chars = 200, $suffix = '...') {
		$content = str_replace("\n", ' ', strip_shortcodes($content));
		if (strlen(strip_tags($content)) > $max_chars) {
			return substr(strip_tags($content), 0, strrpos(substr(strip_tags($content), 0, $max_chars), ' ')+1).$suffix."\n";
		}
		return $content;
	}

	/**
	 * Generate "teaser" text for post. Will use custom excerpt if defined,
	 * otherwise will look for WP "More" tag and return preceding content,
	 * else generate automatic extract via $this->get_extract().
	 * @param integer|WP_Post $post Optional. Post to use (will use global $post if not specified).
	 * @param integer $max_chars Optional. Default 200.
	 * @param string $suffix Optional. Default '...'.
	 * @return string|boolean Teaser text or false on failure
	 * @since 1.0.0
	 */
	private function get_post_extract($post = null, $max_chars = 200, $suffix = '...') {
		$post = get_post($post);
		if (!$post instanceof WP_Post) {
			return false;
		}
		if (!empty($post->post_excerpt)) { // Custom Excerpt
			$output = get_the_excerpt($post);
		} elseif (preg_match('/<!--more(.*?)?-->/', $post->post_content)) { // More
			global $more;
			$tmp_more = $more;
			$more = false;
			$output = get_the_content('', false, $post).$suffix;
			$more = $tmp_more;
		} else {
			$output = $this->get_extract($post->post_content, $max_chars, $suffix);
		}

		return $output;
	}

}
