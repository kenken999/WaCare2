<?php
/**
 * Jetpack Compatibility File
 *
 * @link    https://jetpack.com/
 *
 * @package GreenTech
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 */
function greentech_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'wrapper'   => false,
		'render'    => 'greentech_infinite_scroll_render',
		'footer'    => 'site-content',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support social menu.
	add_theme_support( 'jetpack-social-menu' );

	// Featured content.
	add_theme_support( 'featured-content', array(
		'filter'     => 'greentech_get_featured_posts',
		'max_posts'  => 3,
		'post_types' => array( 'post', 'page' ),
	) );

	// Content options.
	add_theme_support( 'jetpack-content-options', array(
		'blog-display'       => 'content',
		// the default setting of the theme: 'content', 'excerpt' or array( 'content', 'excerpt' ) for themes mixing both display.
		'author-bio'         => false,
		// display or not the author bio: true or false.
		'author-bio-default' => false,
		// the default setting of the author bio, if it's being displayed or not: true or false (only required if false).
		'masonry'            => '.site-main',
		// a CSS selector matching the elements that triggers a masonry refresh if the theme is using a masonry layout.
		'post-details'       => array(
			'stylesheet' => 'greentech-style', // name of the theme's stylesheet.
			'date'       => '.posted-on', // a CSS selector matching the elements that display the post date.
			'categories' => '.cat-links', // a CSS selector matching the elements that display the post categories.
			'tags'       => '.tags-links', // a CSS selector matching the elements that display the post tags.
			'author'     => '.byline', // a CSS selector matching the elements that display the post author.
			'comment'    => '.comments-link', // a CSS selector matching the elements that display the comment link.
		),
		'featured-images'    => array(
			'archive'         => true,
			// enable or not the featured image check for archive pages: true or false.
			'archive-default' => true,
			// the default setting of the featured image on archive pages, if it's being displayed or not: true or false (only required if false).
			'post'            => true,
			// enable or not the featured image check for single posts: true or false.
			'post-default'    => false,
			// the default setting of the featured image on single posts, if it's being displayed or not: true or false (only required if false).
			'page'            => true,
			// enable or not the featured image check for single pages: true or false.
			'page-default'    => false,
			// the default setting of the featured image on single pages, if it's being displayed or not: true or false (only required if false).
		),
	) );
}

add_action( 'after_setup_theme', 'greentech_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function greentech_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) {
			get_template_part( 'template-parts/content', 'search' );
		} elseif ( ! is_search() && ! is_post_type_archive( 'jetpack-portfolio' ) && ! is_tax( 'jetpack-portfolio-type' ) ) {
			get_template_part( 'template-parts/content', get_post_format() );
		} elseif ( is_post_type_archive( 'jetpack-portfolio' ) || is_tax( 'jetpack-portfolio-type' ) ) {
			get_template_part( 'template-parts/content', 'portfolio' );
		}
	}
}


/**
 * Show/Hide Featured Image outside of the loop.
 */
function greentech_jetpack_featured_image_display() {
	if ( ! function_exists( 'jetpack_featured_images_remove_post_thumbnail' ) ) {
		return true;
	}

	$options         = get_theme_support( 'jetpack-content-options' );
	$featured_images = ( ! empty( $options[0]['featured-images'] ) ) ? $options[0]['featured-images'] : null;

	$settings = array(
		'post-default' => ( isset( $featured_images['post-default'] ) && false === $featured_images['post-default'] ) ? '' : 1,
		'page-default' => ( isset( $featured_images['page-default'] ) && false === $featured_images['page-default'] ) ? '' : 1,
	);

	$settings = array_merge( $settings, array(
		'post-option' => get_option( 'jetpack_content_featured_images_post', $settings['post-default'] ),
		'page-option' => get_option( 'jetpack_content_featured_images_page', $settings['page-default'] ),
	) );

	if ( ( ! $settings['post-option'] && is_single() ) || ( ! $settings['page-option'] && is_page() ) ) {
		return false;
	}

	return true;
}

/**
 * Display a Featured Image on archive pages if option is ticked.
 */
function greentech_jetpack_featured_image_archive_display() {
	if ( ! function_exists( 'jetpack_featured_images_remove_post_thumbnail' ) ) {
		return false;
	}

	$options         = get_theme_support( 'jetpack-content-options' );
	$featured_images = ( ! empty( $options[0]['featured-images'] ) ) ? $options[0]['featured-images'] : null;

	$settings = array(
		'archive-default' => ( isset( $featured_images['archive-default'] ) && false === $featured_images['archive-default'] ) ? '' : 1,
	);

	$settings = array_merge( $settings, array(
		'archive-option' => get_option( 'jetpack_content_featured_images_archive', $settings['archive-default'] ),
	) );

	return $settings['archive-option'];
}
