<?php
/**
 * Template part for displaying posts.
 *
 * @since   1.0.0
 * @package ramza
 */

// with sidebar
$post_classes = 'c-post o-box o-box--content';
$image_size   = 'ramza-content-image';

// without sidebar
if ( is_page_template( 'page-template/full-width.php' ) ) {
  $post_classes = 'c-post o-box o-box--full';
  $image_size   = 'ramza-content-image-full';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?>>
  <header class="c-post__header">
    <?php the_title( sprintf( '<h2 class="c-post__title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

    <?php if ( 'post' === get_post_type() ) : ?>
      <?php ramza_posted_on(); ?>
    <?php endif; ?>
  </header><!-- .c-post__header -->

  <?php ramza_print_post_thumbnail( $image_size ); ?>

  <div class="c-post__summary">
    <?php ramza_print_the_content(); ?>
  </div><!-- .c-post__content -->
</article><!-- #post-## -->
