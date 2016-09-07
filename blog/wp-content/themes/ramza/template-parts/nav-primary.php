<?php
/**
 * Template part for displaying the primary navigation (mobile too).
 *
 * @since   1.0.0
 * @package ramza
 */

?>
<?php if ( has_nav_menu( 'primary' ) ) : ?>
<nav id="site-navigation" class="c-nav-primary o-box o-box--header" role="navigation">
  <div class="o-container">

      <div class="c-nav-primary__mobile">
        <div class="c-nav-primary__mobile-toggle"><?php esc_html_e( 'Menu', 'ramza' ); ?></div>
        <div class="c-nav-primary__mobile-toggle-close"><i class="fa fa-close"></i></div>

        <?php
          wp_nav_menu( array(
            'theme_location'  => 'primary',
            'menu_id'         => 'primary-menu-mobile',
            'container'       => false,
            'menu_class'      => 'c-menu-primary-mobile o-menu o-menu--stacked'
          ) );
        ?>
      </div><!-- .c-nav-primary__mobile -->

      <div class="c-nav-primary__desktop">
        <?php
          wp_nav_menu( array(
            'theme_location'  => 'primary',
            'menu_id'         => 'primary-menu',
            'container'       => false,
            'menu_class'      => 'c-menu-primary o-menu o-menu--row'
          ) );
        ?>
      </div><!-- .c-nav-primary__desktop -->

  </div><!-- .o-container -->
</nav><!-- c-nav-primary -->
<?php endif; // if has nav menu primary ?>