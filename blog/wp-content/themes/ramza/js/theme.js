/*------------------------------------------------------------------------------
  fitVids
------------------------------------------------------------------------------*/
/**
 * FitVids.js
 *
 * @since  1.0.0
 */
(function($) {

  'use strict';

  $(document).ready(function(){
    // Target your .container, .wrapper, .post, etc.
    $('.c-post__content, .c-post__summary').fitVids();
  });
})(jQuery);

/*------------------------------------------------------------------------------
  Primary Navigation
------------------------------------------------------------------------------*/
/**
 * Toggle function for the primary mobile menu.
 *
 * @since 1.0.0
 */
(function($) {

  'use strict';

  // Do nothing if Primary Navigation is not found.
  if ( 0 === $('.c-nav-primary').length ) {
    return;
  }

  var $menuMobile = $('.c-menu-primary-mobile'),
      $toggleMenu = $('.c-nav-primary__mobile-toggle'),
      $toggleClose = $('.c-nav-primary__mobile-toggle-close');

  // Main toggle
  $toggleMenu.click( function () {
    $(this).toggleClass('is-active');
    $menuMobile.toggleClass('is-active');
    $toggleClose.toggleClass('is-active');
  });

  // Toggle close
  $toggleClose.click( function () {
    $(this).toggleClass('is-active');
    $menuMobile.toggleClass('is-active');
    $toggleMenu.toggleClass('is-active');
  });


  /* Better menu user experience
  --------------------------------*/
  // Press escape key to close
  $(document).keyup(function(e){
    if (e.keyCode === 27) {
      if ($toggleMenu.hasClass('is-active')) {
        console.log('hello');
        $toggleClose.click();
      }
    }
  });
})(jQuery);


/**
 * Adjust top margin when WP admin bar is
 * shown (when logged in).
 *
 * @since  1.0.0
 */
(function($) {

  'use strict';

  $(document).ready(function(){

    // Do nothing if WP admin bar or Primary Navigation is not found.
    if ( (0 !== $('#wpadminbar').length) || (0 === $('.c-nav-primary').length) ) {
      return;
    }

    var $win                     = $(window),
        $menuMobile              = $('.c-menu-primary-mobile'),
        $menuMobileToggleClose   = $('.c-nav-primary__mobile-toggle'),
        $adminBar                = $('#wpadminbar'),
        menuMobileToggleCloseTop = parseInt($menuMobileToggleClose.css('top')),
        menuMobilePaddingtop     = parseInt($menuMobile.css('paddingTop')),
        adminBarHeight           = $adminBar.outerHeight(),
        newAdminBarHeight,
        resizeTimeout,
        resizeTimeoutTime = 100;


    /**
     * Adds extra padding equal to WP admin bar's height.
     */
    $menuMobile.css('paddingTop', adminBarHeight + menuMobilePaddingtop + 'px' );

    /**
     * Change extra padding value according to the varied
     * heights of WP admin bar for different screen sizes.
     */
    $win.resize(function () {
      if (resizeTimeout) {
        window.clearTimeout(resizeTimeout);
      }

      resizeTimeout = window.setTimeout(function () {
        // Only do something if mobile menu is active.
        if ( $menuMobile.hasClass('is-active') ) {
          return;
        }

        newAdminBarHeight = $adminBar.outerHeight();
        if ( newAdminBarHeight !== adminBarHeight ) {
          adminBarHeight = $adminBar.outerHeight();
          $menuMobile.css('paddingTop', newAdminBarHeight + menuMobilePaddingtop + 'px' );
        }
      }, resizeTimeoutTime);
    }).trigger('resize'); // window resize


    /**
     * Change back to original value for very small screens as
     * WP admin bar changes CSS position property from `fixed`
     * to `absolute`.
     */
    $win.scroll(function(){
      if (resizeTimeout) {
        window.clearTimeout(resizeTimeout);
      }

      resizeTimeout = window.setTimeout(function () {
        if ('absolute' === $adminBar.css('position')) {
          if ( $win.scrollTop() > adminBarHeight ) {
            $menuMobile.css('paddingTop', menuMobilePaddingtop + 'px');
            $menuMobileToggleClose.css('top', menuMobileToggleCloseTop + 'px');
          } else {
            $menuMobile.css('paddingTop', adminBarHeight + menuMobilePaddingtop + 'px');
            $menuMobileToggleClose.css('top', adminBarHeight + menuMobileToggleCloseTop + 'px');
          }
        }
      }, resizeTimeoutTime);
    }).trigger('scroll'); // window scroll
  }); // document ready
})(jQuery);

/*------------------------------------------------------------------------------
  Skip Link Focus
------------------------------------------------------------------------------*/
/**
 * Skip to main content.
 *
 * @since  1.0.0
 */
( function() {
  var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
      is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
      is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

  if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
    window.addEventListener( 'hashchange', function() {
      var id = location.hash.substring( 1 ),
        element;

      if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
        return;
      }

      element = document.getElementById( id );

      if ( element ) {
        if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
          element.tabIndex = -1;
        }

        element.focus();
      }
    }, false );
  }
})();
