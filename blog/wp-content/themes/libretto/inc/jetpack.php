<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Libretto
 */


function libretto_jetpack_setup() {

	/**
	* Add theme support for Infinite Scroll.
	* See: http://jetpack.me/support/infinite-scroll/
	*/
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'content',
		'footer'         => 'colophon',
		'footer_widgets' => array( 'libretto_has_footer_widgets' ),
	) );

	/**
	* Add theme support for Jetpack responsive videos
	* See: http://jetpack.me/support/responsive-videos/
	*/
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'libretto_jetpack_setup' );

/**
* If the social menu or the sidebar widgets are active, switch to click-to-scroll
*/
function libretto_has_footer_widgets() {
	if ( 0 !== count( libretto_get_active_sidebars() )  ) :
		return true;
	else :
		return false;
	endif;
}
add_filter( 'infinite_scroll_has_footer_widgets', 'libretto_has_footer_widgets' );

/**
 * Enable support for site logo
 */
add_theme_support( 'site-logo', array(
	'size' => 'libretto-logo',
) );

/**
 * Remove styles for contact form
 */
function libretto_remove_jetpack_stylesheets() {
	wp_deregister_style( 'grunion.css' );
}
add_action( 'wp_enqueue_scripts', 'libretto_remove_jetpack_stylesheets' );

