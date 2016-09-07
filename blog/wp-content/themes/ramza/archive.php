<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @since   1.0.0
 * @package ramza
 */

get_header(); ?>

  <div id="primary" class="b-content-area">
    <main id="main" class="b-site-main" role="main">

      <?php if ( have_posts() ) : ?>

        <header class="c-page-header o-box o-box--page-header">
          <?php
            the_archive_title( '<h3 class="c-page-header__title">', '</h3>' );
            the_archive_description( '<div class="c-page-header__desc">', '</div>' );
          ?>
        </header><!-- .c-page-header -->

        <div class="c-posts">

          <?php while ( have_posts() ) : the_post(); ?>

            <?php
              /*
               * Include the Post-Format-specific template for the content.
               * If you want to override this in a child theme, then include a file
               * called content-___.php (where ___ is the Post Format name) and that will be used instead.
               */
              get_template_part( 'template-parts/content', get_post_format() );
            ?>

          <?php endwhile; ?>

          <?php ramza_print_posts_nav(); ?>

        </div><!-- .c-posts -->

      <?php else : ?>

        <?php get_template_part( 'template-parts/content', 'none' ); ?>

      <?php endif; ?>

    </main><!-- .b-site-main -->
  </div><!-- .b-content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
