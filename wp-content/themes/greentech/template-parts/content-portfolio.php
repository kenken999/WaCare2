<?php
/**
 * Template part for displaying porrtfolio.
 *
 * @package GreenTech
 */

?>

<div class="project archive-project">
	<a href="<?php the_permalink(); ?>">
		<div class="image"><?php the_post_thumbnail( 'greentech-project' ); ?></div>
	</a>
	<div class="project-info">
		<?php the_title( '<h3 class="project-info-name"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>' );?>
		<h4 class="project-type"><?php the_terms( $post->ID, 'jetpack-portfolio-type' ); ?></h4>
	</div>

</div>
