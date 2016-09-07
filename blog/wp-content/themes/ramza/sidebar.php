<?php
/**
 * The sidebar containing the main widget area.
 *
 * @since   1.0.0
 * @package ramza
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
  return;
}
?>

<div id="secondary" class="b-sidebar-area" role="complementary">
  <div class="c-widgets">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
  </div><!-- .c-widgets -->
</div><!-- .b-sidebar-area -->
