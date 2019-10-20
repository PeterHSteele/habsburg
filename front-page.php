<?php
/**
 * The template for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package habsburg
 */

get_header();
//if home page is set to display recent posts, load the home template hierarchy
if ( 'posts' == get_option( 'show_on_front') ){
	include ( get_home_template() );
} else {
?>
	<div id="habsburg-cards" class="habsburg-card-container">
		<?php 
		for ( $i = 1; $i <= 3; $i++ ){
			habsburg_render_frontpage_cards( null, 'card-' . $i );	
		}
		?>
	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php 
}
get_sidebar();
get_footer();