<?php
/**
 * habsburg Theme Customizer
 *
 * @package habsburg
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function habsburg_customize_register( $wp_customize ) {
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'habsburg_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'habsburg_customize_partial_blogdescription',
		) );

		$wp_customize->add_section( 'habsburg-customizer', array(
			'title' => __( 'Theme Options' , 'habsburg' ),
			'priority' => 1000,
			'active_callback' => 'habsburg_is_featured_content_template'
		));

		for ( $i = 1; $i <= 3; $i++ ){

			$wp_customize->add_setting( 'card-' .$i , array(
				'default' => '',
				'transport' => 'postMessage',
				'sanitize_callback' => 'absint'
			));

			$wp_customize->add_control( 'card-' .$i , array(
				'label' => __( 'Front Page Card ' . $i, 'habsburg' ),
				'description' => sprintf( 
					__( 'Post to use for front page card %d content.' , 'habsburg' ),
					$i
				),
				'section' => 'habsburg-customizer',
				'type' => 'number',
				'setting' => 'card-' . $i
			) );

			$setting = 'card-' . $i;

			$wp_customize->selective_refresh->add_partial( 'card-'.$i, array(
				'settings' => array( $setting ),
				'selector' => '#habsburg-cards #card-' . $i,
				'render_callback' => 'habsburg_render_frontpage_cards'
			));
		}


	}


}
add_action( 'customize_register', 'habsburg_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function habsburg_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function habsburg_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Check if featured-content.php is being used.
 *
 * @return bool 	whether or not featured content template is being used
 */

function habsburg_is_featured_content_template(){
	return is_page_template( array( 'page-templates/featured-content.php' ) );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function habsburg_customize_preview_js() {
	wp_enqueue_script( 'habsburg-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'habsburg_customize_preview_js' );

