<?php
/**
 * Template part for displaying the footer navigation (mobile too).
 *
 * @since   1.0.0
 * @package ramza
 */

?>
<?php if ( has_nav_menu( 'footer' ) || has_nav_menu( 'footer-social' ) ) : ?>

  <nav class="c-nav-footer">
  <?php if ( has_nav_menu( 'footer' ) ) : ?>
    <?php
      wp_nav_menu( array(
        'theme_location'  => 'footer',
        'menu_id'         => 'footer-menu',
        'container'       => false,
        'menu_class'      => 'c-menu-footer o-menu o-menu--row',
        'depth'           => 1
      ) );
    ?>
  <?php endif; // if has nav menu footer ?>

  <?php if ( has_nav_menu( 'footer-social' ) ) : ?>
    <?php
      wp_nav_menu( array(
        'theme_location'  => 'footer-social',
        'menu_id'         => 'footer-social-menu',
        'container'       => false,
        'menu_class'      => 'c-menu-footer-social o-menu o-menu--row',
        'depth'           => 1
      ) );
    ?>
  <?php endif; // if has nav menu footer social ?>
  </nav><!-- c-nav-footer -->

<?php endif; // if has nav menu footer OR footer-social ?>