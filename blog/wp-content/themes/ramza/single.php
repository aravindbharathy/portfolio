<?php
/**
 * The template for displaying all single posts.
 *
 * @since   1.0.0
 * @package ramza
 */

get_header(); ?>

  <div id="primary" class="b-content-area">
    <main id="main" class="b-site-main" role="main">

      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'template-parts/content', 'single' ); ?>

        <?php ramza_print_post_author(); ?>

        <?php ramza_print_post_nav(); ?>

        <?php
          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif;
        ?>

      <?php endwhile; // End of the loop. ?>

    </main><!-- .b-site-main -->
  </div><!-- .b-content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
