<?php
/**
 * Customizer site color settings.
 *
 * @package ramza
 * @since   1.0.0
 */


if ( ! function_exists( 'ramza_customizer_register_colors' ) ) :
/**
 * Register color settings.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ramza_customizer_register_colors( $wp_customize ) {

  // Theme color
  $colors[] = array(
    'slug'      => 'ramza_options[color_theme]',
    'default'   => '#56b890',
    'label'     => __( 'Theme Color', 'ramza' ),
    'priority'  => 1
  );

  // Brand tagline text color
  $colors[] = array(
    'slug'      => 'ramza_options[color_c-brand__tagline]',
    'default'   => '#888888',
    'transport' => 'postMessage',
    'label'     => __( 'Tagline Text Color', 'ramza' ),
  );

  // $colors[] = array(
  //   'slug'      => '',
  //   'default'   => '',
  //   'transport' => 'postMessage',
  //   'label'     => __( '', 'owl' ),
  //   'priority'  => ''
  // );


  /**
   * Loop register color settings.
   */
  foreach( $colors as $color ) {
    $wp_customize->add_setting(
      $color['slug'],
      array(
        'default'           => $color['default'],
        'transport'         => $color['transport'],
        'sanitize_callback' => 'ramza_sanitize_hex_color'
      )
    );
    $wp_customize->add_control(
      $color['slug'],
      array(
        'label'       => $color['label'],
        'description' => $color['description'],
        'section'     => 'colors',
        'type'        => 'color',
        'priority'    => $color['priority']
      )
    );
  }
}
add_action( 'ramza_register_customizer_settings', 'ramza_customizer_register_colors' );
endif;


if ( ! function_exists( 'ramza_set_color_settings_defaults' ) ) :
/**
 * Set default values.
 *
 * @since 1.0.0
 */
function ramza_set_color_settings_defaults( $defaults ) {
  $defaults = array_merge( $defaults, array(
    'color_theme'            => '#56b890',
    'color_c-brand__tagline' => '#888888'
  ) );

  return $defaults;
}
add_filter( 'ramza_option_defaults', 'ramza_set_color_settings_defaults' );
endif;
