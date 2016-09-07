<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @since   1.0.0
 * @package ramza
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function ramza_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'ramza_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function ramza_jetpack_setup
add_action( 'after_setup_theme', 'ramza_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function ramza_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function ramza_infinite_scroll_render
