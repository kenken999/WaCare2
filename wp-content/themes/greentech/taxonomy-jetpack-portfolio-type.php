<?php
/**
 * The template for displaying the Portfolio archive page.
 *
 * @package GreenTech
 */

get_header(); ?>

	<main  class="site-main" role="main">
		<div class="section--archive-project">
			<?php if ( have_posts() ) : ?>
				<div id="main" class="row col-3">
					<?php while ( have_posts() ) : the_post(); ?>
					<div class="project archive-project">
						<a href="<?php the_permalink(); ?>">
							<div class="image"><?php the_post_thumbnail( 'greentech-project' ); ?></div>
						</a>
						<div class="project-info">
							<?php the_title( '<h3 class="project-info-name"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>' );?>
							<h4 class="project-type"><?php the_terms( $post->ID, 'jetpack-portfolio-type' ); ?></h4>
						</div>

					</div>
					<?php endwhile; ?>
				</div>
				<?php
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif; ?>
		</div>
	</main>

<?php
get_footer();
