<?php
/**
 * Plugin Name: Ultimate Fonts
 * Plugin URI: http://wpultimatefonts.com
 * Description: Easily add Google Fonts to your website.
 * Version: 1.0.4
 * Author: GretaThemes
 * Author URI: https://gretathemes.com
 * License: GPL2+
 * Text Domain: ultimate-fonts
 * Domain Path: /languages/
 *
 * @package Ultimate Fonts
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main plugin class.
 *
 * @package Ultimate Fonts
 * @author  Ultimate Fonts <info@wpultimatefonts.com>
 */
class Ultimate_Fonts {
	/**
	 * The reference to singleton instance of this class.
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Plugin dir path.
	 *
	 * @var string
	 */
	public $dir;

	/**
	 * Plugin dir URL.
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Returns the singleton instance of this class.
	 *
	 * @return object The singleton instance.
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Set plugin constants.
	 * Protected constructor to prevent creating a new instance of the singleton via the `new` operator from outside of this class.
	 */
	protected function __construct() {
		$this->dir = plugin_dir_path( __FILE__ );
		$this->url = plugin_dir_url( __FILE__ );
	}

	/**
	 * Initialize the plugin.
	 */
	public function init() {
		$this->set_default();

		// Helper classes.
		require_once $this->dir . 'inc/class-ultimate-fonts-fonts.php';
		require_once $this->dir . 'inc/class-ultimate-fonts-elements.php';

		// Customizer.
		require_once $this->dir . 'inc/class-ultimate-fonts-customizer.php';
		new Ultimate_Fonts_Customizer();

		if ( ! is_admin() ) {
			// Output custom CSS.
			require_once $this->dir . 'inc/class-ultimate-fonts-css.php';
			new Ultimate_Fonts_CSS();
		} elseif ( ! $this->get_theme_support( 'no_settings' ) ) {
			// Register plugin settings page. Allow themes to disable settings with theme support.
			require_once $this->dir . 'inc/class-ultimate-fonts-settings.php';
			new Ultimate_Fonts_Settings();
		}
	}

	/**
	 * Set plugin default option.
	 */
	protected function set_default() {
		$option = get_option( 'ultimate-fonts' );
		if ( ! empty( $option ) ) {
			return;
		}
		$option = array(
			'elements' => array(
				array(
					'label'    => esc_html__( 'Body', 'ultimate-fonts' ),
					'selector' => 'body',
					'forced'   => false,
				),
				array(
					'label'    => esc_html__( 'Headings', 'ultimate-fonts' ),
					'selector' => 'h1, h2, h3, h4, h5, h6',
					'forced'   => false,
				),
			),
		);

		// Allow theme to setup the default elements via theme support.
		$default_elements = $this->get_theme_support( 'default_elements' );
		if ( $default_elements ) {
			$option['elements'] = $default_elements;
		}
		add_option( 'ultimate-fonts', $option );
	}

	/**
	 * Get theme support.
	 *
	 * @param string $name Get theme support option for the plugin.
	 *
	 * @return mixed
	 */
	public function get_theme_support( $name ) {
		$theme_support = get_theme_support( 'ultimate-fonts' );
		if ( ! $theme_support || empty( $theme_support[0] ) || empty( $theme_support[0][ $name ] ) ) {
			return false;
		}

		return $theme_support[0][ $name ];
	}


	/**
	 * Redirect to about page after Meta Box has been activated.
	 *
	 * @param string $plugin       Path to the main plugin file from plugins directory.
	 * @param bool   $network_wide Whether to enable the plugin for all sites in the network
	 *                             or just the current site. Multisite only. Default is false.
	 */
	public function redirect( $plugin, $network_wide ) {
		if ( ! $network_wide && 'ultimate-fonts/ultimate-fonts.php' === $plugin ) {
			wp_safe_redirect( admin_url( 'options-general.php?page=ultimate-fonts' ) );
			die;
		}
	}
}

add_action( 'init', array( Ultimate_Fonts::instance(), 'init' ) );
add_action( 'activated_plugin', array( Ultimate_Fonts::instance(), 'redirect' ), 10, 2 );
