<?php
/**
 * Customizer site footer settings.
 *
 * @package ramza
 * @since   1.0.0
 */


if ( ! function_exists( 'ramza_customizer_register_footer' ) ) :
/**
 * Register footer settings.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ramza_customizer_register_footer( $wp_customize ) {

  // Section
  $wp_customize->add_section(
    'ramza_footer',
    array(
      'priority'    => 20,
      'title'       => __( 'Footer', 'ramza' ),
      'description' => __( 'Footer options.', 'ramza' ),
      // 'panel'       => ''
    )
  );

  // Footer Copyright
  $wp_customize->add_setting(
    'ramza_options[footer_c-copyright_text]',
    array(
      'default'           => sprintf(
        esc_html__( 'Proudly powered by %s%s%s.', 'ramza' ),
        '<a href="' . esc_url( __( 'http://wordpress.org/', 'ramza' ) ) . '">',
        'WordPress',
        '</a>' ),
      'transport'         => 'postMessage',
      'sanitize_callback' => 'ramza_sanitize_html',
    )
  );
  $wp_customize->add_control(
    'ramza_options[footer_c-copyright_text]',
    array(
      'label'       => __( 'Copyright Text', 'ramza' ),
      'description' => __( 'Basic HTML tags are allowed.', 'ramza' ),
      'section'     => 'ramza_footer',
      'type'        => 'textarea'
    )
  );

}
add_action( 'ramza_register_customizer_settings', 'ramza_customizer_register_footer' );
endif;


if ( ! function_exists( 'ramza_set_footer_settings_defaults' ) ) :
/**
 * Set default values.
 *
 * @since 1.0.0
 */
function ramza_set_footer_settings_defaults( $defaults ) {
  $defaults = array_merge( $defaults, array(
    'footer_c-copyright_text' => sprintf(
      esc_html__( 'Proudly powered by %s%s%s.', 'ramza' ),
      '<a href="' . esc_url( __( 'http://wordpress.org/', 'ramza' ) ) . '">',
      'WordPress',
      '</a>' ),
  ) );

  return $defaults;
}
add_filter( 'ramza_option_defaults', 'ramza_set_footer_settings_defaults' );
endif;
