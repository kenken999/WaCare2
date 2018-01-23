<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package GreenTech
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function greentech_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar if don't have sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'greentech_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function greentech_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'greentech_pingback_header' );

/**
 * Demo files for importing.
 *
 * @return array List of demos configuration.
 */
function greentech_import_files() {

	$greentech_demo_url = trailingslashit( get_template_directory_uri() ) . 'demo/';

	return array(
		array(
			'import_file_name'           		=> esc_html__( 'Demo 1', 'greentech' ),
			'local_import_file'            		=> $greentech_demo_url . 'content.xml',
			'local_import_widget_file_url'     	=> $greentech_demo_url . 'widgets.wie',
			'local_import_customizer_file_url' 	=> $greentech_demo_url . 'theme-options.dat',
			'import_preview_image_url'   		=> $greentech_demo_url . 'preview_image.jpg',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'greentech_import_files' );

/**
 * Change the Tag Cloud's Font Sizes
 *
 * @param array $args Widget area.
 *
 * @return array.
 */
function greentech_tag_cloud_fz( $args ) {
	$args['largest'] = 0.875;
	$args['smallest'] = 0.875;
	$args['unit'] = 'rem';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'greentech_tag_cloud_fz' );

/**
 * Setup the theme after importing demo.
 */
function greentech_after_import_setup() {
	// Assign menus to their locations.
	$header = get_term_by( 'slug', 'main-menu', 'nav_menu' );
	$social = get_term_by( 'slug', 'social-menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
		'menu-1'              => $header->term_id,
		'jetpack-social-menu' => $social->term_id,
	) );

	// Setup static front page.
	$front_page = get_page_by_title( 'Home' );
	$blog = get_page_by_title( 'Blog' );
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page->ID );
	update_option( 'page_for_posts', $blog->ID );
	update_option( 'permalink_structure', '/%postname%/' );
}
add_action( 'pt-ocdi/after_import', 'greentech_after_import_setup' );
