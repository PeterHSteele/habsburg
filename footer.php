<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package habsburg
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="footer-flex-container">
			<?php 

			$footer_menus = array( 'footer-menu-1', 'footer-menu-2', 'footer-menu-3' );

			foreach ( $footer_menus as $location ) :
			//Retrieve id of menu in this location

			$menu_id = get_term( get_nav_menu_locations()[ $location ] )->term_id; 

			if (! $menu_id ){
				continue;
			}

			$menu = wp_get_nav_menu_object( $menu_id );

			?>
			<nav class="footer-nav">
				<?php 
					wp_nav_menu( array(
						'menu'		 	 => $menu_id,
						'menu_class' 	 => 'footer-menu-ul',
						'container'	 	 => 'div',
						'container_id'	 => 'footer-menu-container',
						'theme_location' => 'footer-menu',
						'items_wrap'	 => '<h4>'.$menu->name.'</h4><ul class="%2$s">%3$s</ul>'
					));
				?>
			</nav>

			<?php endforeach; ?>
		</div> 
		
		<div class="footer-flex-container">
			<?php dynamic_sidebar( 'footer_widgets' ); ?>
		</div>
		
		<div class="site-info">
		<?php

		the_privacy_policy_link( '<span class="privacy">' , '</span>' );
		/* translators: 1: Theme name, 2: Theme author. */
		printf( esc_html__( 'Theme: %1$s by %2$s.', '_s' ), 'Habsburg' , '<a href="https://peterhsteele.com/">Peter</a>' );
		?>
		</div><!-- .site-info -->
		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
