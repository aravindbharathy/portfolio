<?php
/**
 * Customizer: Sanitization callbacks
 *
 * This file demonstrates how to define
 * sanitization callback functions for
 * various data types.
 *
 * @since   1.0.0
 * @package ramza
 */


if ( ! function_exists( 'ramza_sanitize_checkbox' ) ) :
/**
 * Sanitization: checkbox
 * Control: checkbox
 *
 * Sanitization callback for 'checkbox' type controls.
 * This callback sanitizes $input as a Boolean value, either
 * TRUE or FALSE.
 *
 * @since 1.0.0
 */
function ramza_sanitize_checkbox( $input ) {
  return ( ( isset( $input ) && true == $input ) ? true : false );
}
endif;


if ( ! function_exists( 'ramza_sanitize_css' ) ) :
/**
 * Sanitization: css
 * Control: text, textarea
 *
 * Sanitization callback for 'css' type textarea inputs. This
 * callback sanitizes $input for valid CSS.
 *
 * @since  1.0.0
 */
function ramza_sanitize_css( $input ) {
  return wp_strip_all_tags( $input );
}
endif;


if ( ! function_exists( 'ramza_sanitize_dropdown_pages' ) ) :
/**
 * Sanitization: dropdown-pages
 * Control: dropdown-pages
 *
 * Sanitization callback for 'dropdown-pages' type controls.
 * This callback sanitizes $input as an absolute integer,
 * and then validates that $input is the ID of a published
 * page.
 *
 * @since  1.0.0
 */
function ramza_sanitize_dropdown_pages( $input, $setting ) {
  // Ensure input is an absolute integer
  $input = absint( $input );
  return ( 'publish' == get_post_status( $input ) ? $input : $setting->default );
}
endif;


if ( ! function_exists( 'ramza_sanitize_email' ) ) :
/**
 * Sanitization: email
 * Control: text
 *
 * Sanitization callback for 'email' type text controls.
 * This callback sanitizes $input as a valid email
 * address.
 *
 * @since  1.0.0
 */
function ramza_sanitize_email( $input, $setting ) {
  $email = sanitize_email( $input );
  return ( ! null( $email ) ? $email : $setting->default );
}
endif;


if ( ! function_exists( 'ramza_sanitize_hex_color' ) ) :
/**
 * Sanitization: hex_color
 * Control: text, WP_Customize_Color_Control
 *
 * Sanitization callback hex colors.
 *
 * @since  1.0.0
 */
function ramza_sanitize_hex_color( $input ) {
  return sanitize_hex_color( $input );
}
endif;


if ( ! function_exists( 'ramza_sanitize_html' ) ) :
/**
 * Sanitization: html
 * Control: text, textarea
 *
 * Sanitization callback for 'html' type text inputs. This
 * callback sanitizes $input for HTML allowable in posts.
 *
 * @since  1.0.0
 */
function ramza_sanitize_html( $input ) {
  return wp_filter_post_kses( $input );
}
endif;


if ( ! function_exists( 'ramza_sanitize_image' ) ) :
/**
 * Sanitization: image
 * Control: text, WP_Customize_Image_Control
 *
 * Sanitization callback for images.
 *
 * @uses  wp_check_filetype()   https://developer.wordpress.org/reference/functions/wp_check_filetype/
 * @uses  in_array()        http://php.net/manual/en/function.in-array.php
 */
function ramza_sanitize_image( $input, $setting ) {
  $mimes = array(
      'jpg|jpeg|jpe' => 'image/jpeg',
      'gif'          => 'image/gif',
      'png'          => 'image/png',
      'bmp'          => 'image/bmp',
      'tif|tiff'     => 'image/tiff',
      'ico'          => 'image/x-icon'
  );

  $file = wp_check_filetype( $input, $mimes );

  // If $input has a valid mime_type,
  // return it; otherwise, return
  // the default.
  return ( $file['ext'] ? $input : $setting->default );
}
endif;


if ( ! function_exists( 'ramza_sanitize_nohtml' ) ) :
/**
 * Sanitization: nohtml
 * Control: text, textarea, password
 *
 * Sanitization callback for 'nohtml' type text inputs. This
 * callback sanitizes $input to remove all HTML.
 *
 * @since  1.0.0
 */
function ramza_sanitize_nohtml( $input ) {
  return wp_filter_nohtml_kses( $input );
}
endif;


if ( ! function_exists( 'ramza_sanitize_number_absint' ) ) :
/**
 * Sanitization: number_absint
 * Control: number
 *
 * Sanitization callback for 'number' type text inputs. This
 * callback sanitizes $input as an absolute integer.
 *
 * @since  1.0.0
 */
function ramza_sanitize_number_absint( $input, $setting ) {
  $input = absint( $input );
  return ( $input ? $input : $setting->default );
}
endif;


if ( ! function_exists( 'ramza_sanitize_number_range' ) ) :
/**
 * Sanitization: number_range
 * Control: number, tel
 *
 * Sanitization callback for 'number' or 'tel' type text inputs. This
 * callback sanitizes $input as an absolute integer within a defined
 * min-max range.
 *
 * @since  1.0.0
 */
function ramza_sanitize_number_range( $input ) {

  // Ensure input is an absolute integer
  $input = absint( $input );

  // Get the input attributes
  // associated with the setting
  $atts = $setting->manager->get_control( $setting->id )->input_attrs;

  // Get min
  $min = ( isset( $atts['min'] ) ? $atts['min'] : $input );

  // Get max
  $max = ( isset( $atts['max'] ) ? $atts['max'] : $input );

  // Get Step
  $step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );

  // If the input is within the valid range,
  // return it; otherwise, return the default
  return ( $min <= $input && $input <= $max && is_int( $input / $step ) ? $input : $setting->default );
}
endif;


if ( ! function_exists( 'ramza_sanitize_options' ) ) :
/**
 * Sanitization: options
 * Control: select, radio
 *
 * Sanitization callback for 'select' and 'radio' type controls.
 * This callback sanitizes $input as a slug, and then validates
 * $input against the choices defined for the control.
 *
 * @since 1.0.0
 */
function ramza_sanitize_options( $input, $setting ) {

  // Ensure input is a slug
  $input = sanitize_key( $input );

  // Get list of choices from the control
  // associated with the setting
  $choices = $setting->manager->get_control( $setting->id )->choices;

  // If the input is a valid key, return it;
  // otherwise, return the default
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;


if ( ! function_exists( 'ramza_sanitize_url' ) ) :
/**
 * Sanitization: url
 * Control: text, url
 *
 * Sanitization callback for 'url' type text inputs. This
 * callback sanitizes $input as a valid URL.
 *
 * @since  1.0.0
 */
function ramza_sanitize_url( $input ) {
  return esc_url_raw( $input );
}
endif;
