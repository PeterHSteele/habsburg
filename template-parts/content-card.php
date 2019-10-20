<?php
/**
 * Template part for displaying a card on the front page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package habsburg
 */

?>
<a href="<?php the_permalink() ?>" id="habsburg-card<?php echo $id?>" <?php post_class( 'habsburg-card' ); ?> >
	<article >
		<header>
			<?php the_title('<h2 class="habsburg-card-title">', '</h2>'); ?>
		</header>
		<?php 
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large');
		the_post_thumbnail();
		?>
		<!--
		<div class="habsburg-card-body" style="background-image: url(<?php echo esc_url( $thumbnail[0] ); ?>)">
			
		</div>
	-->
		<div class="habsburg-teaser">
			<?php the_excerpt(); ?>
		</div>
	</article>
</a>