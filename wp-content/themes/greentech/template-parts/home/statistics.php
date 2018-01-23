<?php
/**
 * The template part for displaying statistics section on front page
 *
 * @package Greentech
 */

// Default value.
$statistics_number_default = array( '', '30+', '$34500', '347', '485%' );
$statistics_ico_default = array( '', '/images/icon1.png', '/images/icon2.png', '/images/icon3.png', '/images/icon4.png' );
$statistics_text_default = array( '', 'Years Of Experience', 'Funds Collected', 'Volunteers Involved', 'Animals Saved' );
$statistics_textarea_default = '<h2>1500+</h2>
								<h3><strong>PEOPLE WORKING WITH US</strong></h3>
								Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.';

$statistics_bg = get_theme_mod( 'statistics_bg', get_template_directory_uri() . '/images/statistics_bg.jpg' );
$statistics_section_title = get_theme_mod( 'statistics_section_title', esc_html__( 'Some Interesting Facts', 'greentech' ) );
$statistics_textarea = get_theme_mod( 'statistics_textarea', $statistics_textarea_default );

for ( $i = 0; $i <= 4; $i++ ) {
	$number_mod = get_theme_mod( 'statistics_item_number_' . $i, $statistics_number_default[ $i ] );
	$text_mod = get_theme_mod( 'statistics_item_text_' . $i, $statistics_text_default[ $i ] );
	$icon_mod = get_theme_mod( 'statistics_item_icon_' . $i, get_template_directory_uri() . $statistics_ico_default[ $i ] );
	$statistics_item_number[] = $number_mod;
	$statistics_item_text[] = $text_mod;
	$statistics_item_icon[] = $icon_mod;
}

?>

<section class="section--statistics">

	<?php if ( ! empty( $statistics_textarea ) ) : ?>
	<div class="statistics-textarea container">
		<?php echo wp_kses_post( wpautop( $statistics_textarea ) ); ?>
	</div>
	<?php endif; ?>


	<?php if ( ! empty( $statistics_section_title ) && count( $statistics_item_number ) > 0 && count( $statistics_item_text ) > 0 && count( $statistics_item_icon ) > 0 ) : ?>
	<div class="statistic-four-column" style="background-image: url('<?php echo esc_url( $statistics_bg ) ?>')">
		<div class="container">
			<h2 class="section-title"><?php echo esc_html( $statistics_section_title ) ?></h2>
			<div class="statistics-content">
				<?php for ( $i = 1; $i <= 4; $i++ ) { ?>
					<div class="statistics-item item-<?php echo esc_attr( $i ) ?>">
						<?php if ( ! empty( $statistics_item_icon[ $i ] ) ) :  ?>
							<div class="statistics-icon">
							<?php
								$icon_id = function_exists( 'wpcom_vip_attachment_url_to_postid' ) ? wpcom_vip_attachment_url_to_postid( $featured_block_icon[ $i ] ) : attachment_url_to_postid( $statistics_item_icon[ $i ] );
								$icon_alt = get_post_meta( $icon_id, '_wp_attachment_image_alt', true );
							?>
							<img src="<?php echo esc_url( $statistics_item_icon[ $i ] ) ?>" alt="<?php echo esc_attr( $icon_alt ) ?>">
							</div>
						<?php endif; ?>
						<div class="statistics-number"><?php echo esc_html( $statistics_item_number[ $i ] ) ?></div>
						<div class="statistics-text"><?php echo esc_html( $statistics_item_text[ $i ] ) ?></div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

</section>
