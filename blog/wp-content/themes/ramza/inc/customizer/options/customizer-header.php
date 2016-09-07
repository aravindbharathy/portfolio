<?php
/**
 * Customizer site header settings.
 *
 * @package ramza
 * @since   1.0.0
 */


if ( ! function_exists( 'ramza_customizer_register_header' ) ) :
/**
 * Register header settings.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ramza_customizer_register_header( $wp_customize ) {

  // Section
  $wp_customize->add_section(
    'ramza_header',
    array(
      'priority'    => 20,
      'title'       => __( 'Header', 'ramza' ),
      'description' => __( 'Header options.', 'ramza' ),
      // 'panel'       => ''
    )
  );

  // header Copyright
  $wp_customize->add_setting(
    'ramza_options[header_b-site__header_padding]',
    array(
      'default'           => 60,
      'transport'         => 'postMessage',
      'sanitize_callback' => 'ramza_sanitize_number_absint',
    )
  );
  $wp_customize->add_control(
    'ramza_options[header_b-site__header_padding]',
    array(
      'label'       => __( 'Brand Padding', 'ramza' ),
      'description' => __( 'Enter a number.', 'ramza' ),
      'section'     => 'ramza_header',
      'type'        => 'text'
    )
  );

}
add_action( 'ramza_register_customizer_settings', 'ramza_customizer_register_header' );
endif;


if ( ! function_exists( 'ramza_set_header_settings_defaults' ) ) :
/**
 * Set default values.
 *
 * @since 1.0.0
 */
function ramza_set_header_settings_defaults( $defaults ) {
  $defaults = array_merge( $defaults, array(
    'header_b-site__header_padding' => 60
  ) );

  return $defaults;
}
add_filter( 'ramza_option_defaults', 'ramza_set_header_settings_defaults' );
endif;
