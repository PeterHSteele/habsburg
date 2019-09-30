<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package habsburg
 */

if ( ! function_exists( 'habsburg_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function habsburg_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'habsburg' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( '_habsburg_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function _habsburg_posted_by( $sep = '' ) {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( '%s by %s%s', 'post author', 'habsburg' ),
			'<span><i class="fas fa-sm fa-user"></i></span>',
			'<span class="author"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>',
			$sep
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( '_habsburg_posted_in' ) ) :
	/**
	 * Prints HTML with meta information for the categories.
	 */
	function _habsburg_posted_in( $sep = '' ){
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'habsburg' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( 
					'<span class="cat-links">' . esc_html__( '%2$s Posted in %1$s%3$s', 'habsburg' ) . '</span>',
					$categories_list,
					'<span><i class="fas fa-sm fa-folder-open"></i></span>',
					$sep 
				); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( '_habsburg_tagged') ) : 
	/**
	 * Prints HTML with meta information for tags.
	 */
	function _habsburg_tagged( $sep = '' ){
		if ( get_post_type() === 'post' ){

			$tag_list = get_the_tag_list( ' ', esc_html__( ', ' , 'habsburg' ) );
			if ( $tag_list ){
				/* translators: 1: list of tags. 2: separator */
				printf( 
					'<span class="tag-links"><i class="fas fa-sm fa-tags"></i></span><span>%1$s</span>%2$s',
					$tag_list,
					$sep
				);
			}

		}
	}

endif;

if ( ! function_exists( 'habsburg_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function habsburg_entry_footer() {
		// Hide category and tag text for pages.
		//if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			//$categories_list = get_the_category_list( esc_html__( ', ', '_s' ) );
			//if ( $categories_list ) {
				/* translators: 1: list of categories. */
				//printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', '_s' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			//}

		//}

		//Print tag list
			
		if ( function_exists('_habsburg_tagged') ){
			_habsburg_tagged( ' | ' );
		}

		?>
		<span class="sep"> </span>
		<?php

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'habsburg' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'habsburg' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'habsburg_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function habsburg_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'habsburg_nav_search' ) ) :
/**
	 * Displays the nav searchbar. Depending on the $direction parameter, 
	 * the search bar will display either before or after the primary menu.
*/
	function habsburg_nav_search( $direction ){
	?>
		<form  class="nav-search-form <?php echo $direction ?>" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" placeholder='search' name="s" class="nav-search-field">
			<button role="button" type="button" class='nav-search-expand nav-toggle-button'>
				<i class="fa fa-search"></i>
			</button>
		</form>

	<?php
	}

endif;