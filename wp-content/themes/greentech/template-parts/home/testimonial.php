<?php
/**
 * Template part for displaying testimonials.
 *
 * @package GreenTech
 */

if ( ! post_type_exists( 'jetpack-testimonial' ) ) {
	return;
}

$args = array(
	'post_type' => 'jetpack-testimonial',
);

$query = new WP_Query( $args );
if ( ! $query->have_posts() ) {
	return;
}
?>
<section class="section--tess">
	<div class="container">
		<div class="tess">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<div class="tes">
					<div class="content"><?php the_content(); ?></div>
					<div class="image"><?php the_post_thumbnail( 'full' ); ?></div>
					<div class="info">
						<p class="name"><?php the_title(); ?></p>
						<strong class="title">
							<?php
							$caption = get_post( get_post_thumbnail_id() )->post_excerpt;
							echo esc_html( $caption );
							?>
						</strong>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</section>
