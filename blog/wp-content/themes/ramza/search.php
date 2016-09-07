<?php
/**
 * The template for displaying search results pages.
 *
 * @since   1.0.0
 * @package ramza
 */

get_header(); ?>

  <div id="primary" class="b-content-area">
    <main id="main" class="b-site-main" role="main">

      <?php if ( have_posts() ) : ?>

        <header class="c-page-header o-box o-box--page-header">
          <h3 class="c-page-header__title"><?php printf( esc_html__( 'Search Results for: %s', 'ramza' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
        </header><!-- .c-page-header -->

        <div class="c-posts">

          <?php /* Start the Loop */ ?>
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
