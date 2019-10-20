<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package habsburg
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<?php
//Conditionally apply no-sidebar styles 
$body_class = '';
if ( is_page_template( 'page-templates/no-sidebar.php' ) ){
	$body_class .= ' no-sidebar';
}
?>

<body <?php body_class( $body_class ); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'habsburg' ); ?></a>

	<header id="masthead" class="site-header">

		
		<div class="site-branding">
			<?php the_header_image_tag(); ?>
			<?php
			the_custom_logo();
			if ( get_post_type() == 'page' && ! is_search() || is_front_page() || is_home() ) : 
				if ( is_front_page() || is_home() ) :
					?>
					<h1 class="site-title aligncenter"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title aligncenter"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
			endif;
			$_habsburg_description = get_bloginfo( 'description', 'display' );
			if ( $_habsburg_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $habsburg_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
		<nav id="site-navigation" class="main-navigation">
			<?php if ( function_exists( 'the_custom_logo' ) ){
				the_custom_logo();
			}
			?>

			<?php habsburg_nav_search( 'left' ); ?>

			<button type="button" id="menu-toggle" role="button" class="menu-toggle nav-toggle-button" aria-controls="primary-menu" aria-expanded="false">
				<i class="fa fa-bars"></i>
			</button>
			
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>

			<!--nav searchbar-->
			<?php habsburg_nav_search( 'right' ); ?>

		</nav><!-- #site-navigation -->
		
	</header><!-- #masthead -->

	<div id="content" class="site-content">
