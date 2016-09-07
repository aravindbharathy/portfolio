<?php
/**
 * Theme Customizer main functions.
 *
 * @since   1.0.0
 * @package ramza
 */


if ( ! function_exists( 'ramza_customizer_register' ) ) :
/**
 * Register theme custom customizer settings.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ramza_customizer_register( $wp_customize ) {
  /**
   * Modify some WP default settings to fit the theme
   */
  $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
  $wp_customize->remove_control( 'display_header_text' );
  $wp_customize->get_control( 'header_image' )->section       = 'title_tagline';
  // $wp_customize->remove_section( 'background_image' );

  /**
   * Add hook to easily add custom options.
   *
   * @since 1.0.0
   *
   * @param WP_Customize_Manager $wp_customize Theme Customizer object.
   */
  do_action( 'ramza_register_customizer_settings', $wp_customize );
}
add_action( 'customize_register', 'ramza_customizer_register' );
endif;


if ( ! function_exists( 'ramza_get_customizer_dir' ) ) :
/**
 * Get customizer directory.
 *
 * @since  1.0.0
 *
 * @return string Customizer directory path.
 */
function ramza_get_customizer_dir() {
  return get_template_directory() . '/inc/customizer';
}
endif;


if ( ! function_exists( 'ramza_get_customizer_dir_uri' ) ) :
/**
 * Get customizer directory uri.
 *
 * @since  1.0.0
 *
 * @return string Customizer directory path.
 */
function ramza_get_customizer_dir_uri() {
  return get_template_directory_uri() . '/inc/customizer';
}
endif;


if ( ! function_exists( 'ramza_customizer_enqueue' ) ) :
/**
 * Enqueue scripts.
 *
 * @since 1.0.0
 */
function ramza_customizer_enqueue() {
  wp_enqueue_script(
    'ramza_customizer',
    ramza_get_customizer_dir_uri() . '/js/post-message.js',
    array( 'customize-preview' ),
    RAMZA_VERSION,
    true
  );
}
add_action( 'customize_preview_init', 'ramza_customizer_enqueue' );
endif;


if ( ! function_exists( 'ramza_get_option_defaults' ) ) :
/**
 * Get customizer setting default values.
 *
 * @since 1.0.0
 */
function ramza_get_option_defaults() {
  $defaults = array();

  /**
   * Easily add default values for new settings with
   * this filter.
   *
   * @since  1.0.0
   *
   * @return array $defaults Customizer default values.
   */
  return apply_filters( 'ramza_option_defaults', $defaults );
}
endif;


if ( ! function_exists( 'ramza_get_options' ) ) :
/**
 * Get theme customizer options.
 *
 * @since 1.0.0
 *
 * @uses   ramza_get_option_defaults() Get default setting values
 * @return array         $options           Customizer values.
 */
function ramza_get_options() {
  $options = get_theme_mod( 'ramza_options' );
  return wp_parse_args( $options, ramza_get_option_defaults() );
}
endif;


/**
 * Adds customizer sanitization.
 */
require ramza_get_customizer_dir() . '/sanitize.php';


/**
 * Adds function to lighten/darken color.
 */
require ramza_get_customizer_dir() . '/lighten-color.php';


/**
 * Adds customizer custom options.
 */
require ramza_get_customizer_dir() . '/options/customizer-colors.php';
require ramza_get_customizer_dir() . '/options/customizer-header.php';
require ramza_get_customizer_dir() . '/options/customizer-content.php';
require ramza_get_customizer_dir() . '/options/customizer-footer.php';


if ( ! function_exists( 'ramza_print_customizer_options_css' ) ) :
/**
 * Print CSS of customizer settings values.
 *
 * @since 1.0.0
 */
function ramza_print_customizer_options_css() {
  require ramza_get_customizer_dir() . '/options/options-css.php';
}
add_action( 'wp_head', 'ramza_print_customizer_options_css', 99 );
endif;


if ( ! function_exists( 'ramza_print_customizer_settings_js' ) ) :
/**
 * Print JS of customizer settings values.
 *
 * @since 1.0.0
 */
function ramza_print_customizer_options_js() {
  require ramza_get_customizer_dir() . '/options/options-js.php';
}
add_action( 'wp_footer', 'ramza_print_customizer_options_js', 99 );
endif;