<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Greentech
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses greentech_header_style()
 */
function greentech_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'greentech_custom_header_args', array(
		'default-text-color' => 'fff',
		'width'              => 1920,
		'height'             => 500,
		'flex-width'         => true,
		'flex-height'        => true,
		'default-image'      => get_template_directory_uri() . '/images/bg_breadcrumb.jpg',
		'wp-head-callback'   => 'greentech_header_style',
	) ) );
	register_default_headers( array(
		'work-space' => array(
			'url'           => '%s/images/bg_breadcrumb.jpg',
			'thumbnail_url' => '%s/images/bg_breadcrumb.jpg',
			'description'   => esc_html__( 'Work Space', 'greentech' ),
		),
	) );
}

add_action( 'after_setup_theme', 'greentech_custom_header_setup' );

if ( ! function_exists( 'greentech_header_style' ) ) :
	/**
	 * Show the header image and optionally hide the site title, site description.
	 */
	function greentech_header_style() {
		$style = '';
		if ( has_header_image() ) {
			$style .= '.page-header { background: url(' . esc_url( get_header_image() ) . ') top center no-repeat; background-attachment: fixed; }';
		}
		if ( ! display_header_text() ) {
			$style .= '.site-title, .site-description { clip: rect(1px, 1px, 1px, 1px); position: absolute; }';
		}
		if ( $style ) :
			?>
			<style id="greentech-header-css">
				<?php echo $style; // WPCS: XSS OK. ?>
			</style>
			<?php
		endif;
	}
endif;
