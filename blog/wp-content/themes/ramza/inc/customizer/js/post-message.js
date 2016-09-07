/**
 * Theme Customizer enhancements for a better user experience.
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since  1.0.0
 */

( function( $ ) {
  /*--------------------------------------------------------------
  # Brand
  --------------------------------------------------------------*/
  wp.customize( 'blogname', function( value ) {
    value.bind( function( newVal ) {
      $( '.c-brand__logo span' ).text( newVal );
    } );
  } );
  wp.customize( 'blogdescription', function( value ) {
    value.bind( function( newVal ) {
      $( '.c-brand__tagline' ).text( newVal );
    } );
  } );

  /*--------------------------------------------------------------
  # Colors
  --------------------------------------------------------------*/
  // Brand logo text color.
  wp.customize( 'header_textcolor', function( value ) {
    value.bind( function( newVal ) {
      $( '.c-brand__logo' ).css( {
        'color': newVal
      } );
    } );
  } );

  // Brand tagline text color.
  wp.customize( 'ramza_options[color_c-brand__tagline]', function( value ) {
    value.bind( function( newVal ) {
      $( '.c-brand__tagline' ).css( {
        'color': newVal
      } );
    } );
  } );


  /*--------------------------------------------------------------
  # Header
  --------------------------------------------------------------*/
  // Brand padding
  wp.customize( 'ramza_options[header_b-site__header_padding]', function( value ) {
    value.bind( function( newVal ) {
      $( '.b-site__header' ).css( {
        'padding': newVal + 'px 0'
      } );
    } );
  } );


  /*--------------------------------------------------------------
  # Content
  --------------------------------------------------------------*/
  // Sidebar Pos
  wp.customize( 'ramza_options[content_b-sidebar-area_pos]', function( value ) {
    value.bind( function( newVal ) {
      if ( newVal !== 'right' ) {
        $( '.b-content-area' ).css( 'float', 'right' );
        $( '.b-sidebar-area' ).css( 'float', 'left' );
      }
    } );
  } );


  /*--------------------------------------------------------------
  # Footer
  --------------------------------------------------------------*/
  // Copyright Text
  wp.customize( 'ramza_options[footer_c-copyright_text]', function( value ) {
    value.bind( function( newVal ) {
      $( '.c-copyright' ).html( newVal );
    } );
  } );
} )( jQuery );
