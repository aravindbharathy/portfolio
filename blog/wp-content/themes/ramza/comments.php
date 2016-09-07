<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @since   1.0.0
 * @package ramza
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
  return;
}

$o_box_mod = is_page_template( 'page-templates/full-width.php' ) ? 'full' : 'content';
?>

<?php if ( have_comments() ) : ?>
  <section id="comments" class="c-comments o-box o-box--<?php echo esc_attr( $o_box_mod ); ?>">

      <h3 class="c-comments__title">
      <?php
        // Do not title for pages
        if ( is_page() ) {
          printf(
            esc_html( _nx(
              'One Thought',
              '%1$s Thoughts',
              get_comments_number(),
              'comments title heading',
              'ramza'
            ) ),
            number_format_i18n( get_comments_number() )
          );
        } else {
          // show title for posts
          printf(
              esc_html( _nx(
                'One Thought on %2$s',
                '%1$s Thoughts on %2$s',
                get_comments_number(),
                'comments title heading',
                'ramza'
              ) ),
              number_format_i18n( get_comments_number() ),
              '<small>' . get_the_title() . '</small>'
            );
        }
      ?>
      </h3>

      <ol class="c-comments__list o-ui-list">
        <?php
          wp_list_comments( array(
            'style'      => 'ol',
            'short_ping' => true,
            'callback'   => 'ramza_list_comments'
          ) );
        ?>
      </ol><!-- .c-comment-list -->

  </section><!-- #comments -->


  <?php ramza_print_comments_nav(); ?>


<?php endif; // have_comments() ?>


<?php
  // If comments are closed and there are comments, let's leave a little note, shall we?
  if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
?>
  <div class="c-comments c-comments--no-comments o-box o-box--content">
    <span><?php esc_html_e( 'Comments are closed.', 'ramza' ); ?></span>
  </div>
<?php endif; ?>


<?php ramza_comment_form(); ?>
