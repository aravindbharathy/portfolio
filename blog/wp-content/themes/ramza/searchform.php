<?php
/**
 * The template for displaying search form.
 *
 * @since   1.0.0
 * @package ramza
 */

?>

<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
  <label>
    <span class="u-screen-reader-text"><?php echo _x( 'Search for:', 'label', 'ramza' ) ?></span>
    <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search...', 'search placeholder', 'ramza' ); ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'ramza' ); ?>" />
  </label>
  <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'ramza' ); ?>" />
</form>