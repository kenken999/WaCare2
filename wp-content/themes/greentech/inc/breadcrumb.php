<?php
/**
 * Greentech breadcrumbs
 *
 * @package Greentech
 */

/**
 * Breadcrumb at the header
 */
function greentech_breadcrumb() {
	// Settings.
	$breadcrumbs_id    = 'breadcrumb';
	$breadcrumbs_class = 'breadcrumb';
	$home_title        = esc_html__( 'Home', 'greentech' );

	// If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat).
	$custom_taxonomy = 'product_cat';

	// Do not display on the homepage.
	if ( ! is_front_page() ) {
		?>

		<?php
		$breadcrumb = '<ul id="' . $breadcrumbs_id . '" class="' . $breadcrumbs_class . '"><li class="breadcrumb-item home"><a href="' . esc_url( get_home_url() ) . '" title="' . $home_title . '">' . $home_title . '</a></li>';

		if ( is_archive() && ! is_tax() && ! is_category() && ! is_tag() && ! is_author() && ! is_home() && ! is_year() && ! is_month() && ! is_day() ) {
			echo $breadcrumb; // WPCS: XSS OK.
			?>
			<li class="breadcrumb-item active"><?php echo post_type_archive_title( '', false ); ?></li></ul>
			<?php
			echo '<h1 class="page-title">' . post_type_archive_title( '', false ) . '</h1>';

		} elseif ( is_home() ) {
			echo $breadcrumb; // WPCS: XSS OK.
			echo '<li class="breadcrumb-item active">' . get_queried_object()->post_title . '</li></ul>'; // WPCS: XSS OK.
			echo '<h1 class="page-title">' . get_queried_object()->post_title . '</h1>'; // WPCS: XSS OK.

		} elseif ( is_archive() && is_tax() && ! is_category() && ! is_tag() && ! is_author() && ! is_year() ) {

			// If post is a custom post type.
			$post_type       = get_post_type();
			$custom_tax_name = get_queried_object()->name;

			echo $breadcrumb; // WPCS: XSS OK.
			// If it is a custom post type display name and link.
			if ( 'post' !== $post_type ) {

				$post_type_object  = get_post_type_object( $post_type );
				$post_type_archive = get_post_type_archive_link( $post_type );
				?>
				<li class="breadcrumb-item">
					<a href="<?php echo esc_url( $post_type_archive ); ?>" title="<?php echo esc_attr( $post_type_object->labels->name ); ?>"><?php echo $post_type_object->labels->name; // WPCS: XSS OK. ?></a>
				</li>
				<?php
			}
			?>

			<li class="breadcrumb-item active"><?php echo $custom_tax_name; // WPCS: XSS OK. ?></li></ul>
			<?php
			echo '<h1 class="page-title">' . $custom_tax_name . '</h1>'; // WPCS: XSS OK.

		} elseif ( is_single() ) {

			// If post is a custom post type.
			$post_type = get_post_type();

			// If it is a custom post type display name and link.
			if ( 'post' !== $post_type ) {

				$post_type_object  = get_post_type_object( $post_type );
				$post_type_archive = get_post_type_archive_link( $post_type );

				echo $breadcrumb; // WPCS: XSS OK.
				?>
				<li class="breadcrumb-item">
					<a href="<?php echo esc_url( $post_type_archive ); ?>" title="<?php echo esc_attr( $post_type_object->labels->name ); ?>"><?php echo $post_type_object->labels->name; // WPCS: XSS OK. ?></a>
				</li>
				<?php
			}

			// Get post category info.
			$category = get_the_category();

			if ( ! empty( $category ) ) {

				// Get last category post is in.
				$values        = array_values( $category );
				$last_category = end( $values );

				// Get parent any categories and create array.
				$get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
				$cat_parents     = explode( ',', $get_cat_parents );

				// Loop through parent categories and store in variable $cat_display.
				$cat_display = '';
				foreach ( $cat_parents as $parents ) {
					$cat_display .= '<li class="breadcrumb-item item-cat">' . $parents . '</li>';
				}
			}

			// If it's a custom post type within a custom taxonomy.
			$taxonomy_exists = taxonomy_exists( $custom_taxonomy );
			if ( empty( $last_category ) && ! empty( $custom_taxonomy ) && $taxonomy_exists ) {

				$taxonomy_terms = get_the_terms( get_the_ID(), $custom_taxonomy );
				$cat_id         = $taxonomy_terms[0]->term_id;
				$cat_link       = get_term_link( $taxonomy_terms[0]->term_id, $custom_taxonomy );
				$cat_name       = $taxonomy_terms[0]->name;

			}

			// Check if the post is in a category.
			if ( ! empty( $last_category ) ) {

				echo $breadcrumb; // WPCS: XSS OK.
				echo $cat_display; // WPCS: XSS OK.
				?>
				<li class="breadcrumb-item active"><?php echo get_the_title(); ?></li></ul>
				<?php
				echo '<h2 class="page-title">' . get_the_title() . '</h2>';

				// Else if post is in a custom taxonomy.
			} elseif ( ! empty( $cat_id ) ) {

				echo $breadcrumb; // WPCS: XSS OK.
				?>
				<li class="breadcrumb-item">
					<a href="<?php echo esc_url( $cat_link ); ?>" title="<?php echo esc_attr( $cat_name ); ?>"><?php echo $cat_name; // WPCS: XSS OK. ?></a>
				</li>
				<li class="breadcrumb-item active"><?php echo get_the_title(); ?></li></ul>
				<?php
				echo '<h2 class="page-title">' . get_the_title() . '</h2>';

			} else {
				?>
				<li class="breadcrumb-item active"><?php echo get_the_title(); ?></li></ul>
				<?php
				echo '<h2 class="page-title">' . get_the_title() . '</h2>'; // WPCS: XSS OK.

			}
		} elseif ( is_category() ) {
			// Category page.
			echo $breadcrumb; // WPCS: XSS OK.
			?>
			<li class="breadcrumb-item active"><?php echo single_cat_title( '', false ); ?></li></ul>
			<?php
			echo '<h1 class="page-title">' . single_cat_title( '', false ) . '</h1>';

		} elseif ( is_page() ) {
			$parent_id = wp_get_post_parent_id( get_the_id() );

			// Standard page.
			if ( $parent_id ) {
				// If child page, get parents.
				$anc = get_post_ancestors( get_the_id() );
				// Get parents in the right order.
				$anc = array_reverse( $anc );

				// Display parent pages.
				echo $breadcrumb; // WPCS: XSS OK.

				// Output the ancestor if the page isn't the child page of home.
				if ( absint( get_option( 'page_on_front' ) ) !== $parent_id ) {
					// Parent page loop.
					foreach ( $anc as $ancestor ) {
						?>
						<li class="breadcrumb-item">
							<a href="<?php echo esc_url( get_permalink( $ancestor ) ); ?>" title="<?php echo esc_attr( get_the_title( $ancestor ) ); ?>"><?php echo get_the_title( $ancestor ); ?></a>
						</li>
						<?php
					}
				}
				?>
				<li class="breadcrumb-item active"><?php echo get_the_title(); ?></li></ul>
				<?php
				echo '<h2 class="page-title">' . get_the_title() . '</h2>';

			} else {

				// Just display current page if not parents.
				echo $breadcrumb; // WPCS: XSS OK.
				?>
				<li class="breadcrumb-item active"><?php echo get_the_title(); ?></li></ul>
				<?php
				echo '<h2 class="page-title">' . get_the_title() . '</h2>';

			}
		} elseif ( is_tag() ) {

			// Tag page.
			// Get tag information.
			$term_id       = get_query_var( 'tag_id' );
			$taxonomy      = 'post_tag';
			$args          = 'include=' . $term_id;
			$terms         = get_terms( $taxonomy, $args );
			$get_term_name = $terms[0]->name;

			// Display the tag name.
			echo $breadcrumb; // WPCS: XSS OK.
			?>
			<li class="breadcrumb-item active">
				<?php
				/* translators: tag name */
				printf( esc_html__( 'Tag: %s', 'greentech' ), esc_html( $get_term_name ) ); // WPCS: XSS OK.
				?>
			</li></ul>
			<?php
			echo '<h1 class="page-title">' . esc_html__( 'Tag', 'greentech' ) . '</h1>';

		} elseif ( is_day() ) {

			// Day archive.
			echo $breadcrumb; // WPCS: XSS OK.
			?>
			<li class="breadcrumb-item">
				<a href="<?php echo esc_html( get_year_link( get_the_time( 'Y' ) ) ); ?>" title="<?php echo esc_attr( get_the_time( 'Y' ) ); ?>"><?php echo get_the_time( 'Y' ); // WPCS: XSS OK. ?></a>
			</li>
			<li class="breadcrumb-item">
				<a href="<?php echo esc_html( get_month_link( get_the_time( 'Y' ) ), get_the_time( 'm' ) ); ?>" title="<?php echo esc_attr( get_the_time( 'M' ) ); ?>"><?php echo get_the_time( 'M' ); // WPCS: XSS OK. ?></a>
			</li>
			<li class="breadcrumb-item active"><?php echo get_the_time( 'jS' ) . ' ' . get_the_time( 'M' ); // WPCS: XSS OK. ?></li><ul>
			<?php
			echo '<h1 class="page-title">' . get_the_time( 'jS' ) . ' ' . get_the_time( 'M' ) . '</h1>'; // WPCS: XSS OK.

		} elseif ( is_month() ) {

			// Month Archive.
			echo $breadcrumb; // WPCS: XSS OK.
			?>
			<li class="breadcrumb-item">
				<a href="<?php echo esc_html( get_year_link( get_the_time( 'Y' ) ) ); ?>" title="<?php echo esc_attr( get_the_time( 'Y' ) ); ?>"><?php echo get_the_time( 'Y' ); // WPCS: XSS OK. ?></a>
			</li>
			<li class="breadcrumb-item active"><?php echo get_the_time( 'M' ); // WPCS: XSS OK. ?></li></ul>
			<?php
			echo '<h1 class="page-title">' . get_the_time( 'M' ) . '</h1>'; // WPCS: XSS OK.

		} elseif ( is_year() ) {
			// Display year archive.
			echo $breadcrumb; // WPCS: XSS OK.
			?>
			<li class="breadcrumb-item active"><?php echo get_the_time( 'Y' ); // WPCS: XSS OK. ?></li></ul>
			<?php
			echo '<h1 class="page-title">' . get_the_time( 'Y' ) . '</h1>'; // WPCS: XSS OK.

		} elseif ( is_author() ) {

			// Display author name.
			echo $breadcrumb; // WPCS: XSS OK.
			?>
			<li class="breadcrumb-item active"><?php the_archive_title(); ?></li></ul>
			<?php
			echo '<h1 class="page-title">' . esc_html__( 'Author', 'greentech' ) . '</h1>';

		} elseif ( is_search() ) {

			// Search results page.
			echo $breadcrumb; // WPCS: XSS OK.
			?>
			<li class="breadcrumb-item active">
				<?php
				/* translators: search query */
				printf( esc_html__( 'Search Results for: %s', 'greentech' ), esc_html( get_search_query() ) ); ?>
			</li></ul>
			<?php
			echo '<h1 class="page-title">' . esc_html__( 'Search', 'greentech' ) . '</h1>';

		} elseif ( is_404() ) {

			// 404 page.
			echo $breadcrumb; // WPCS: XSS OK.
			?>
			<li class="breadcrumb-item active"><?php echo esc_html__( 'Error 404', 'greentech' ); ?></li></ul>
			<?php
			echo '<h1 class="page-title">' . esc_html__( 'Error 404', 'greentech' ) . '</h1>';

		}// End if().
	}// End if().
}
