<?php
/**
 * Template Name: featured content
 * The template for displaying the front page ( optional ) or any other page 
 * you want to feature some content on
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package habsburg
 */

get_header();
?>
	<!--display featured posts-->
	<div id="habsburg-cards" class="habsburg-card-container">
		<?php
		for ( $i = 1; $i <= 3; $i++ ){
			habsburg_render_frontpage_cards( null, 'card-' . $i );	
		}
		?>
	</div>
	<!--Same as page.php from here on out-->
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

get_sidebar();
get_footer();