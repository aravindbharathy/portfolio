<?php
/**
 * Function to lighten or darken color.
 *
 * @package ramza
 * @since   1.0.0
 */


if ( ! function_exists( 'ramza_lighten' ) ) :
/**
 * Lightens or darkens HEX value.
 *
 * @see   http://lab.clearpixel.com.au/2008/06/darken-or-lighten-colours-dynamically-using-php/
 *
 * @since 1.0.0
 */
function ramza_lighten( $hex, $percent ) {
  // Work out if hash given
  $hash = '';
  if ( stristr( $hex, '#' ) ) {
    $hex = str_replace( '#', '', $hex );
    $hash = '#';
  }
  /// HEX TO RGB
  $rgb = array( hexdec( substr( $hex, 0, 2 ) ),  hexdec( substr( $hex, 2, 2 ) ),  hexdec( substr( $hex, 4, 2 ) ) );
  //// CALCULATE
  for ( $i = 0; $i < 3; $i++ ) {
    // See if brighter or darker
    if ( $percent > 0 ) {
      // Lighter
      $rgb[$i] = round( $rgb[$i] * $percent ) + round( 255 * ( 1 - $percent ) );
    } else {
      // Darker
      $positivePercent = $percent - ( $percent * 2 );
      $rgb[$i] = round( $rgb[$i] * $positivePercent ) + round( 0 * ( 1 - $positivePercent ) );
    }
    // In case rounding up causes us to go to 256
    if ( $rgb[$i] > 255 ) {
      $rgb[$i] = 255;
    }
  }
  //// RBG to Hex
  $hex = '';
  for( $i = 0; $i < 3; $i++ ) {
    // Convert the decimal digit to hex
    $hexDigit = dechex( $rgb[$i] );
    // Add a leading zero if necessary
    if( strlen( $hexDigit ) == 1 ) {
      $hexDigit = "0" . $hexDigit;
    }
    // Append to the hex string
    $hex .= $hexDigit;
  }
  return $hash . $hex;
}
endif;
