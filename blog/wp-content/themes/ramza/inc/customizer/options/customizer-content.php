<?php
/**
 * Customizer site content settings.
 *
 * @package ramza
 * @since   1.0.0
 */


if ( ! function_exists( 'ramza_customizer_register_content' ) ) :
/**
 * Register content settings.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ramza_customizer_register_content( $wp_customize ) {

  // Section
  $wp_customize->add_section(
    'ramza_content',
    array(
      'priority'    => 20,
      'title'       => __( 'Content', 'ramza' ),
      'description' => __( 'Content options.', 'ramza' ),
      // 'panel'       => ''
    )
  );

  // content Copyright
  $wp_customize->add_setting(
    'ramza_options[content_b-sidebar-area_pos]',
    array(
      'default'           => 'right',
      'transport'         => 'postMessage',
      'sanitize_callback' => 'ramza_sanitize_options',
    )
  );
  $wp_customize->add_control(
    'ramza_options[content_b-sidebar-area_pos]',
    array(
      'label'       => __( 'Sidebar Position', 'ramza' ),
      // 'description' => __( '', 'ramza' ),
      'section'     => 'ramza_content',
      'type'        => 'select',
      'choices'     => array(
        'left'  => __( 'Left', 'ramza' ),
        'right' => __( 'Right', 'ramza' )
      )
    )
  );

}
add_action( 'ramza_register_customizer_settings', 'ramza_customizer_register_content' );
endif;


if ( ! function_exists( 'ramza_set_content_settings_defaults' ) ) :
/**
 * Set default values.
 *
 * @since 1.0.0
 */
function ramza_set_content_settings_defaults( $defaults ) {
  $defaults = array_merge( $defaults, array(
    'content_b-sidebar-area_pos' => 'right'
  ) );

  return $defaults;
}
add_filter( 'ramza_option_defaults', 'ramza_set_content_settings_defaults' );
endif;
