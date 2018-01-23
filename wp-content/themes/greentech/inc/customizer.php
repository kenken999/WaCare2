<?php
/**
 * Greentech Theme Customizer
 *
 * @package GreenTech
 */

/**
 * Include custom control class.
 */
require_once get_template_directory() . '/inc/class-greentech-custom-heading.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function greentech_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Add theme options panel.
	$wp_customize->add_panel( 'greentech', array(
		'title'           => esc_html__( 'Theme Options', 'greentech' ),
		'active_callback' => 'is_front_page',
	) );

	// Slider section.
	$wp_customize->add_section( 'slider_section', array(
		'title' => esc_html__( 'Slider Section', 'greentech' ),
		'panel' => 'greentech',
	) );

	$wp_customize->add_setting( 'slider_speed', array(
		'sanitize_callback' => 'absint',
		'default'           => 5000,
	) );
	$wp_customize->add_control( 'slider_speed', array(
		'label'           => esc_html__( 'Top slider speed', 'greentech' ),
		'section'         => 'slider_section',
		'type'            => 'number',
		'active_callback' => 'is_front_page',
		'description'     => esc_html__( 'The animation speed in milliseconds. Enter 0 to disable the slider.', 'greentech' ),
	) );

	/**
	 * Featured Blocks section.
	 */
	$wp_customize->add_section( 'featured_block_section', array(
		'title' => esc_html__( 'Featured Blocks', 'greentech' ),
		'panel' => 'greentech',
	) );

	$featured_block_text_default = array(
		__( 'HOW TO <br> SAVE THE PLANET EARTH', 'greentech' ),
		__( 'THE IMPORTANCE <br> OF RECYCLING ENVIROMENT', 'greentech' ),
		__( 'MANY ALTERNATIVE <br> GREEN  ENERGY SOURCES', 'greentech' ),
	);
	for ( $i = 1; $i <= 3; $i ++ ) {
		$wp_customize->add_setting( 'featured_block_heading_' . $i, array(
			'type'              => 'info_control',
			'sanitize_callback' => 'esc_attr',
		) );
		$wp_customize->add_control( new Greentech_Custom_Heading(
			$wp_customize,
			'featured_block_heading_' . $i,
			array(
				'label'    => __( 'Featured Block ', 'greentech' ) . $i,
				'section'  => 'featured_block_section',
				'settings' => 'featured_block_heading_' . $i,
			)
		) );

		$wp_customize->add_setting( 'featured_block_text_' . $i, array(
			'sanitize_callback' => 'greentech_sanitize_text',
			'transport'         => 'postMessage',
			'default'           => $featured_block_text_default[ $i - 1 ],
		) );
		$wp_customize->add_control( 'featured_block_text_' . $i, array(
			'label'           => esc_html__( 'Featured Block Text', 'greentech' ),
			'section'         => 'featured_block_section',
			'type'            => 'text',
			'active_callback' => 'is_front_page',
		) );

		$wp_customize->add_setting( 'featured_block_url' . $i, array(
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( 'featured_block_url' . $i, array(
			'label'           => esc_html__( 'Featured Block Link', 'greentech' ),
			'section'         => 'featured_block_section',
			'type'            => 'text',
			'active_callback' => 'is_front_page',
		) );

		$wp_customize->add_setting( 'featured_block_icon_' . $i, array(
			'sanitize_callback' => 'greentech_sanitize_image',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'featured_block_section_' . $i,
			array(
				'label'           => esc_html__( 'Featured Block Icon', 'greentech' ),
				'section'         => 'featured_block_section',
				'description'     => esc_html__( 'Recommended size: 64x64 pixels.', 'greentech' ),
				'settings'        => 'featured_block_icon_' . $i,
				'active_callback' => 'is_front_page',
			)
		) );
	}// End for().

	/**
	 * Features section.
	 */
	$wp_customize->add_section( 'features_section', array(
		'title' => esc_html__( 'Features Section', 'greentech' ),
		'panel' => 'greentech',
	) );

	$wp_customize->add_setting( 'features_section', array(
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'features_section', array(
		'label'           => esc_html__( 'Features Page', 'greentech' ),
		'section'         => 'features_section',
		'type'            => 'dropdown-pages',
		'active_callback' => 'is_front_page',
		'description'     => wp_kses_post( __( 'The content of this page will be displayed below the slider on your static front page.', 'greentech' ) ),
	) );

	$wp_customize->selective_refresh->add_partial(
		'features_section',
		array(
			'selector'            => '.section--features',
			'container_inclusive' => true,
			'render_callback'     => 'greentech_refresh_features_section',
		)
	);

	/**
	 * Services section.
	 */
	$wp_customize->add_section( 'services_section', array(
		'title' => esc_html__( 'Services Section', 'greentech' ),
		'panel' => 'greentech',
	) );

	// Default Setting Services Section.
	$services_bg_default = get_template_directory_uri() . '/images/services_bg.png';

	$wp_customize->add_setting( 'services_section_title', array(
		'default'           => esc_html__( 'Services', 'greentech' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'services_section_title', array(
		'label'           => esc_html__( 'Services Section Title', 'greentech' ),
		'section'         => 'services_section',
		'type'            => 'text',
		'active_callback' => 'is_front_page',
	) );

	for ( $i = 1; $i <= 6; $i ++ ) {
		$wp_customize->add_setting( 'front_page_services_' . $i, array(
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'front_page_services_' . $i, array(
			'label'           => esc_html__( 'Service Page ', 'greentech' ) . $i,
			'section'         => 'services_section',
			'type'            => 'dropdown-pages',
			'active_callback' => 'is_front_page',
		) );

		$wp_customize->selective_refresh->add_partial(
			'front_page_services_' . $i,
			array(
				'selector'            => '.section--services',
				'container_inclusive' => true,
				'render_callback'     => 'greentech_refresh_services_section',
			)
		);
	}

	// Upload image to add background image.
	$wp_customize->add_setting( 'services_section_img', array(
		'sanitize_callback' => 'greentech_sanitize_image',
		'default'           => $services_bg_default,
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'services_section',
		array(
			'label'           => esc_html__( 'Centered Image', 'greentech' ),
			'section'         => 'services_section',
			'description'     => esc_html__( 'Choose the services section background', 'greentech' ),
			'settings'        => 'services_section_img',
			'active_callback' => 'is_front_page',
		)
	) );

	/**
	 * Statistics section.
	 */
	$wp_customize->add_section( 'statistics_section', array(
		'title' => esc_html__( 'Statistics Section', 'greentech' ),
		'panel' => 'greentech',
	) );

	// Default Setting Statistics Section.
	$statistics_number_default = array( '', '30+', '$34500', '347', '485%' );
	$statistics_text_default   = array(
		'',
		__( 'Years Of Experience', 'greentech' ),
		__( 'Funds Collected', 'greentech' ),
		__( 'Volunteers Involved', 'greentech' ),
		__( 'Animals Saved', 'greentech' ),
	);
	$statistics_bg_default     = get_template_directory_uri() . '/images/statistics_bg.jpg';
	$statistics_ico_default    = array(
		'',
		'/images/icon1.png',
		'/images/icon2.png',
		'/images/icon3.png',
		'/images/icon4.png',
	);

	$wp_customize->add_setting( 'statistics_textarea', array(
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
		'default'           => __( '<h2>1500+</h2><h3>PEOPLE WORKING WITH US</h3>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.', 'greentech' ),
	) );

	$wp_customize->add_control( 'statistics_textarea', array(
		'type'    => 'textarea',
		'label'   => esc_html__( 'Content', 'greentech' ),
		'section' => 'statistics_section',
		'setting' => 'statistics_textarea',
	) );

	$wp_customize->add_setting( 'statistics_bg', array(
		'sanitize_callback' => 'greentech_sanitize_image',
		'default'           => $statistics_bg_default,
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'statistics_bg',
		array(
			'label'           => esc_html__( 'Background Image', 'greentech' ),
			'section'         => 'statistics_section',
			'settings'        => 'statistics_bg',
			'active_callback' => 'is_front_page',
		)
	) );

	$wp_customize->add_setting( 'statistics_section_title', array(
		'default'           => esc_html__( 'Some interesting fact', 'greentech' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'statistics_section_title', array(
		'label'           => esc_html__( 'Statistics Section Title', 'greentech' ),
		'section'         => 'statistics_section',
		'type'            => 'text',
		'active_callback' => 'is_front_page',
	) );

	for ( $i = 1; $i <= 4; $i ++ ) {

		$wp_customize->add_setting( 'greentech_heading_' . $i, array(
			'type'              => 'info_control',
			'sanitize_callback' => 'esc_attr',
		) );
		$wp_customize->add_control( new Greentech_Custom_Heading(
			$wp_customize,
			'greentech_heading_' . $i,
			array(
				'label'    => __( 'Item ', 'greentech' ) . $i,
				'section'  => 'statistics_section',
				'settings' => 'greentech_heading_' . $i,
			)
		) );

		$wp_customize->add_setting( 'statistics_item_number_' . $i, array(
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
			'default'           => $statistics_number_default[ $i ],
		) );
		$wp_customize->add_control( 'statistics_item_number_' . $i, array(
			'label'           => esc_html__( 'Number', 'greentech' ),
			'section'         => 'statistics_section',
			'type'            => 'text',
			'active_callback' => 'is_front_page',
		) );

		$wp_customize->add_setting( 'statistics_item_text_' . $i, array(
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
			'default'           => $statistics_text_default[ $i ],
		) );
		$wp_customize->add_control( 'statistics_item_text_' . $i, array(
			'label'           => esc_html__( 'Title', 'greentech' ),
			'section'         => 'statistics_section',
			'type'            => 'text',
			'active_callback' => 'is_front_page',
		) );

		$wp_customize->add_setting( 'statistics_item_icon_' . $i, array(
			'sanitize_callback' => 'greentech_sanitize_image',
			'default'           => get_template_directory_uri() . $statistics_ico_default[ $i ],
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'statistics_item_icon_' . $i,
			array(
				'label'           => esc_html__( 'Image', 'greentech' ),
				'section'         => 'statistics_section',
				'settings'        => 'statistics_item_icon_' . $i,
				'active_callback' => 'is_front_page',
			)
		) );

	}// End for().

	/**
	 * Projects section.
	 */
	$wp_customize->add_section( 'projects_section', array(
		'title' => esc_html__( 'Projects Section', 'greentech' ),
		'panel' => 'greentech',
	) );

	$wp_customize->add_setting( 'projects_section_title', array(
		'default'           => esc_html__( 'Projects', 'greentech' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'projects_section_title', array(
		'label'           => esc_html__( 'Projects Section Title', 'greentech' ),
		'section'         => 'projects_section',
		'type'            => 'text',
		'active_callback' => 'is_front_page',
	) );

	$wp_customize->add_setting( 'projects_section_layout', array(
		'default'           => 'slider',
		'sanitize_callback' => 'greentech_sanitize_radio',
	) );

	$wp_customize->add_control( 'projects_section_layout', array(
		'label'           => esc_html__( 'Projects Section Layout', 'greentech' ),
		'section'         => 'projects_section',
		'type'            => 'radio',
		'choices'         => array(
			'grid'   => esc_html__( 'Grid', 'greentech' ),
			'slider' => esc_html__( 'Slider', 'greentech' ),
		),
		'active_callback' => 'is_front_page',
		'description'     => wp_kses_post( __( 'Select the layout for the projects section in homepage.', 'greentech' ) ),
	) );

	$wp_customize->selective_refresh->add_partial(
		'projects_section_layout',
		array(
			'selector'            => '.section--projects',
			'container_inclusive' => true,
			'render_callback'     => 'greentech_refresh_portfolio_section',
		)
	);

	$wp_customize->add_setting( 'portfolio_number_grid', array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'greentech_validate_project_number',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'portfolio_number_grid', array(
		'label'           => esc_html__( 'Number Of Projects In Portfolio Section', 'greentech' ),
		'section'         => 'projects_section',
		'type'            => 'select',
		'choices'         => array(
			0  => esc_html__( 'Do not display Portfolio section', 'greentech' ),
			3  => 3,
			6  => 6,
			9  => 9,
			12 => 12,
		),
		'active_callback' => 'is_front_page',
	) );

	$wp_customize->selective_refresh->add_partial(
		'portfolio_number_grid',
		array(
			'selector'            => '.section--projects',
			'container_inclusive' => true,
			'render_callback'     => 'greentech_refresh_portfolio_section',
		)
	);

	/**
	 * Posts section.
	 */
	$wp_customize->add_section( 'blog_section', array(
		'title' => esc_html__( 'Blog Section', 'greentech' ),
		'panel' => 'greentech',
	) );

	$wp_customize->add_setting( 'blog_section_title', array(
		'default'           => esc_html__( 'Latest News', 'greentech' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'blog_section_title', array(
		'label'           => esc_html__( 'Blog Section Title', 'greentech' ),
		'section'         => 'blog_section',
		'type'            => 'text',
		'active_callback' => 'is_front_page',
	) );

	$wp_customize->add_setting( 'greentech_blog_number', array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'greentech_validate_project_number',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'greentech_blog_number', array(
		'label'           => esc_html__( 'Number Of Posts In Blog Section', 'greentech' ),
		'section'         => 'blog_section',
		'type'            => 'select',
		'choices'         => array(
			0  => esc_html__( 'Do not display Blog section', 'greentech' ),
			3  => 3,
			6  => 6,
			9  => 9,
			12 => 12,
		),
		'active_callback' => 'is_front_page',
	) );

	$wp_customize->selective_refresh->add_partial(
		'greentech_blog_number',
		array(
			'selector'            => '.section--blog',
			'container_inclusive' => true,
			'render_callback'     => 'greentech_refresh_blog_section',
		)
	);

	/**
	 * CTA section.
	 */
	$wp_customize->add_section( 'cta_section', array(
		'title' => esc_html__( 'Call To Action Section', 'greentech' ),
		'panel' => 'greentech',
	) );

	// Call to action text.
	$wp_customize->add_setting( 'cta_text', array(
		'default'           => wp_kses_post( __( 'Join us now to access the new tech', 'greentech' ) ),
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'cta_text', array(
		'label'           => esc_html__( 'Call To Action Text', 'greentech' ),
		'section'         => 'cta_section',
		'type'            => 'textarea',
		'active_callback' => 'is_front_page',
	) );

	// Call to action links.
	$wp_customize->add_setting( 'cta_button_text', array(
		'default'           => esc_html__( 'Get In Touch', 'greentech' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'cta_button_text', array(
		'label'           => esc_html__( 'Call To Action Link Text', 'greentech' ),
		'section'         => 'cta_section',
		'type'            => 'text',
		'active_callback' => 'is_front_page',
	) );

	$wp_customize->add_setting( 'cta_button_url', array(
		'default'           => esc_url( 'https://gretathemes.com/' ),
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'cta_button_url', array(
		'label'           => esc_html__( 'Call To Action Link URL', 'greentech' ),
		'section'         => 'cta_section',
		'type'            => 'text',
		'active_callback' => 'is_front_page',
	) );

	// Call to action background.
	$wp_customize->add_setting( 'cta_background', array(
		'sanitize_callback' => 'greentech_sanitize_image',
		'default'           => get_template_directory_uri() . '/images/cta-bg.jpg',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'cta_section',
		array(
			'label'           => esc_html__( 'Call To Action Backround Image', 'greentech' ),
			'section'         => 'cta_section',
			'settings'        => 'cta_background',
			'active_callback' => 'is_front_page',
		)
	) );
}

add_action( 'customize_register', 'greentech_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function greentech_customize_preview_js() {
	wp_enqueue_script( 'greentech_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20170818', true );
}

add_action( 'customize_preview_init', 'greentech_customize_preview_js' );


/**
 * Sanitize radio choices.
 *
 * @param string               $input   choice slug.
 * @param WP_Customize_Setting $setting Setting instance.
 *
 * @return string User choices; otherwise, the setting default.
 */
function greentech_sanitize_radio( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Sanitize featured block text.
 *
 * @param string $input text.
 *
 * @return string sanitized text.
 */
function greentech_sanitize_text( $input ) {
	$allowed_html = array(
		'br' => array(),
	);

	return wp_kses( $input, $allowed_html );
}

/**
 * Sanitizes Image Upload.
 *
 * @param string $input potentially dangerous data.
 *
 * @return string
 */
function greentech_sanitize_image( $input ) {
	$filetype = wp_check_filetype( $input );
	if ( $filetype['ext'] && wp_ext2type( $filetype['ext'] ) === 'image' ) {
		return esc_url( $input );
	}
	return '';
}

/**
 * Validation number of projects to show
 *
 * @param object $validity Validity object.
 * @param int    $value    The option value.
 *
 * @return object
 */
function greentech_validate_project_number( $validity, $value ) {
	$new_value = absint( $value );
	if ( $new_value != $value ) {
		$validity->add( 'invalid number', esc_html__( 'You must select valid number', 'greentech' ) );
	}
	return $validity;
}

/**
 * Live refresh project section.
 */
function greentech_refresh_portfolio_section() {
	get_template_part( 'template-parts/home/projects' );
}

/**
 * Live refresh blog section.
 */
function greentech_refresh_blog_section() {
	get_template_part( 'template-parts/home/blog' );
}

/**
 * Live refresh services section.
 */
function greentech_refresh_services_section() {
	get_template_part( 'template-parts/home/services' );
}


/**
 * Live refresh features section.
 */
function greentech_refresh_features_section() {
	get_template_part( 'template-parts/home/features' );
}

