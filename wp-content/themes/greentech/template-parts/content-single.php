<?php
/**
 * Template part for displaying single post
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package GreenTech
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	// If single post has media, don't ouput it above the content.
	$main_content = apply_filters( 'the_content', get_the_content() );
	if ( in_array( get_post_format(), array( 'audio', 'video' ), true ) ) {
		$media = get_media_embedded_in_content( $main_content, array(
			'audio',
			'video',
			'object',
			'embed',
			'iframe',
		) );
	}
	if ( greentech_jetpack_featured_image_display() && ! $media ) {
		get_template_part( 'template-parts/content', 'media' );
	}
	?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'greentech' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php greentech_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
