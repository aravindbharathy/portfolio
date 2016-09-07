<?php
/**
 *  CSS of all customizer settings.
 *
 * @package ramza
 * @since   1.0.0
 */

// Break points
$media_s = 500;
$media_m = 801;
$media_l = 1025;
$media_xl = 1290;

$theme_options = ramza_get_options();
?>
<!-- =================================
  THEME SETTINGS CSS START
================================== -->
<style id="ramza-css">
/*------------------------------------------------------------------------------
  Header
------------------------------------------------------------------------------*/
<?php if ( 60 !== $theme_options['header_b-site__header_padding'] ) : ?>
.b-site__header {
  padding: <?php echo esc_html( $theme_options['header_b-site__header_padding'] ); ?>px 0;
  padding: <?php echo esc_html( $theme_options['header_b-site__header_padding'] )/16; ?>rem 0;
}
<?php endif; ?>

/*------------------------------------------------------------------------------
  Colors
------------------------------------------------------------------------------*/
<?php if ( '#888888' !== $theme_options['color_c-brand__tagline'] ) : ?>
.c-brand__tagline {
  color: <?php echo esc_html( $theme_options['color_c-brand__tagline'] ); ?>;
}
<?php endif; ?>


<?php if ( '#56b890' !== $theme_options['color_theme'] ) : ?>
a,
.c-post.sticky:before,
.c-comment__author-name:hover,
.c-comment__author-name:active,
.c-comment__author-name a:hover,
.c-comment__author-name a:active,
.widget_calendar #prev a:hover,
.widget_calendar #prev a:active,
.widget_calendar #next a:hover,
.widget_calendar #next a:active {
  color: <?php echo esc_html( $theme_options['color_theme'] ); ?>;
}

/* Hovered color */
a:hover,
a:focus,
a:active,
.o-nav-content a:hover,
.o-nav-content a:active,
.c-post__meta a:hover,
.c-post__meta a:active,
.c-post__meta a:focus,
.c-post__pages a .c-post__page:hover,
.c-post__pages a .c-post__page:active,
.c-post__nav-link a:hover,
.c-post__nav-link a:active,
.c-post__nav-link a:focus,
.widget_recent_entries a:hover,
.widget_recent_entries a:active,
.widget_recent_entries a:focus,
.widget_recent_comments a:hover,
.widget_recent_comments a:active,
.widget_recent_comments a:focus,
.widget_archive a:hover,
.widget_archive a:active,
.widget_archive a:focus,
.widget_categories a:hover,
.widget_categories a:active,
.widget_categories a:focus,
.widget_meta a:hover,
.widget_meta a:active,
.widget_meta a:focus,
.widget_pages a:hover,
.widget_pages a:active,
.widget_pages a:focus,
.widget_nav_menu a:hover,
.widget_nav_menu a:active,
.widget_nav_menu a:focus,
.widget_rss a:hover,
.widget_rss a:active,
.widget_rss a:focus {
  color: <?php echo esc_html( ramza_lighten( $theme_options['color_theme'], '-0.90' ) ); ?>;
}


button,
input[type="button"],
input[type="reset"],
input[type="submit"],
.o-btn,
.c-nav-primary__mobile-toggle.is-active,
.bypostauthor .c-comment__author-name,
.bypostauthor .c-comment__author-name a,
.widget_tag_cloud a:hover,
.widget_tag_cloud a:active,
.widget_calendar tbody a {
  background-color: <?php echo esc_html( $theme_options['color_theme'] ); ?> !important;
}


/* Hovered color */
button:hover,
input[type="button"]:hover,
input[type="reset"]:hover,
input[type="submit"]:hover,
.o-btn:hover,
.c-nav-primary__mobile-toggle-close:hover,
.c-nav-primary__mobile-toggle-close:active,
.c-posts-nav a:hover,
.c-posts-nav a:active,
.c-comments-nav a:hover,
.c-comments-nav a:active,
.widget_calendar tbody a:hover,
.widget_calendar tbody a:active,
#infinite-handle span:hover,
#infinite-handle span:active {
  background-color: <?php echo esc_html( ramza_lighten( $theme_options['color_theme'], '-0.90' ) ); ?>;
}


blockquote {
  border-color: <?php echo esc_html( $theme_options['color_theme'] ); ?>;
}
<?php endif; ?>


/*------------------------------------------------------------------------------
  Content
------------------------------------------------------------------------------*/
<?php if ( 'right' !== $theme_options['content_b-sidebar-area_pos'] ) : ?>
@media screen and (min-width: <?php echo esc_html( $media_m ); ?>px) {
  .b-content-area {
    float: right;
  }

  .b-sidebar-area {
    float: left;
  }
}

<?php endif; ?>
</style>
<!-- =================================
  THEME SETTINGS CSS END
================================== -->