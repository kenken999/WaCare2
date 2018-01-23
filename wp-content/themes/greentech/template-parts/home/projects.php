<?php
/**
 * Template part for displaying projects.
 *
 * @package GreenTech
 */

$project_number = get_theme_mod( 'portfolio_number_grid', 6 );

if ( ! $project_number ) {
	return;
}

if ( ! post_type_exists( 'jetpack-portfolio' ) ) {
	return;
}

$args  = array(
	'post_type'      => 'jetpack-portfolio',
	'posts_per_page' => $project_number,
);
$query = new WP_Query( $args );

if ( ! $query->have_posts() ) {
	return;
}

$layout = get_theme_mod( 'projects_section_layout', 'slider' );

$post_count = count( $query->posts );

$class = array( 'projects row' );
switch ( $post_count ) {
	case 1:
		$class[] = 'grid--center col-1';
		break;
	case 2:
	case 4:
		array_push( $class, 'grid--center', 'col-2' );
		break;
	default:
		$class[] = 'col-3';
		break;
}
?>
<section class="section--projects">
	<div class="container">

		<h2 class="section-title"><?php echo esc_html( get_theme_mod( 'projects_section_title', __( 'Projects', 'greentech' ) ) ); ?></h2>
		<div class="projects-wrap">
			<?php if ( 'grid' === $layout ) : ?>
			<div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>">
			<?php else : ?>
			<div class="projects projects--slider">
			<?php endif; ?>
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<div class="project">
						<a href="<?php the_permalink(); ?>">
							<div class="image"><?php the_post_thumbnail( 'greentech-project' ); ?></div>
						</a>
						<div class="project-info">
							<?php the_title( '<h3 class="project-info-name"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
							<p class="desc"><?php echo wp_kses_post( get_the_content() ); ?></p>
						</div>
					</div>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</div>
		</div>
		<div class="wrap-btn">
			<a class="btn btn-primary btn-view-all" href="<?php echo wp_kses_post( get_post_type_archive_link( 'jetpack-portfolio' ) ); ?>"><?php esc_attr_e( 'More Projects', 'greentech' ); ?></a>
		</div>
	</div>
</section>
