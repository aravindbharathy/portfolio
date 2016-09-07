<?php
/**
 * Custom admin related functions.
 *
 * @since   1.1.0
 * @package ramza
 */


function ramza_add_theme_docs_page() {
  add_theme_page( 'Theme Documentation', 'Theme Documentation', 'edit_theme_options', 'theme-docs', 'ramza_print_theme_docs_page' );
}
add_action( 'admin_menu', 'ramza_add_theme_docs_page' );

function ramza_print_theme_docs_page() {
  ?>
  <h2><?php esc_html_e( 'Theme Documetantion', 'ramza' ); ?></h2>
  <div class="card">
    <h3><?php esc_html_e( 'Table of Contents', 'ramza' ); ?></h3>
    <p>
      <a href="http://docs.made4wp.com/wordpress-basics/"><?php esc_html_e( 'WordPress Basics', 'ramza' ); ?></a><br>
      <a href="http://docs.made4wp.com/ramza/#setup"><?php esc_html_e( 'Setup', 'ramza' ); ?></a><br>
      <a href="http://docs.made4wp.com/ramza/#menu-locations"><?php esc_html_e( 'Menu Locations', 'ramza' ); ?></a><br>
      <a href="http://docs.made4wp.com/ramza/#widget-areas"><?php esc_html_e( 'Widget Areas', 'ramza' ); ?></a><br>
      <a href="http://docs.made4wp.com/ramza/#theme-options"><?php esc_html_e( 'Theme Options', 'ramza' ); ?></a>
    </p>
  </div>
  <?php
}