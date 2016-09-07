<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @since   1.0.0
 * @package ramza
 */


if ( ! function_exists( 'ramza_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time,
 * author and comments.
 *
 * @since  1.0.0
 */
function ramza_posted_on() {
  // Date
  $time_string = '<time class="c-post__date published updated" datetime="%1$s">%2$s</time>';
  // if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
  //   $time_string = '<time class="c-post__date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
  // }

  $time_string = sprintf( $time_string,
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() )
    // esc_attr( get_the_modified_date( 'c' ) ),
    // esc_html( get_the_modified_date() )
  );

  $posted_on = sprintf(
    esc_html_x( 'Posted on %s', 'post date', 'ramza' ),
    '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
  );


  // Author
  $author = sprintf(
    esc_html_x( 'by %s', 'post author', 'ramza' ),
    '<span class="c-post__author__link vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
  );


  if ( 'post' === get_post_type() ) {
    echo '<div class="c-post__meta c-post__meta--header">';
      // Date and Author
      echo '<span class="c-posted-on"><i class="fa fa-clock-o"></i>' . $posted_on . '</span><span class="c-author"><i class="fa fa-user"></i>' . $author . '</span>'; // WPCS: XSS OK.
        // Comments
      if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="c-post__comments-link"><i class="fa fa-comments"></i>';
        comments_popup_link( esc_html__( 'Leave a comment', 'ramza' ), esc_html__( '1 Comment', 'ramza' ), esc_html__( '% Comments', 'ramza' ) );
        echo '</span>';
      }
    echo '</div><!-- .c-post__meta -->';
  }
}
endif;


if ( ! function_exists( 'ramza_print_post_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * @since  1.0.0
 */
function ramza_print_post_footer() {
  // Do nothing for pages.
  if ( 'post' !== get_post_type() ) {
    return;
  }

  $categories_list = get_the_category_list( ', ' );
  $tags_list       = get_the_tag_list( '', ', ' );

  echo '<div class="c-post__meta c-post__meta--footer">';
    if ( $categories_list && ramza_categorized_blog() ) {
      printf( '<div class="c-post__cats"><i class="fa fa-folder"></i>' . esc_html__( 'Posted in %1$s', 'ramza' ) . '</div>', $categories_list ); // WPCS: XSS OK.
    }
    if ( $tags_list ) {
      printf( '<div class="c-post__tags"><i class="fa fa-tags"></i>' . esc_html__( 'Tagged %1$s', 'ramza' ) . '</div>', $tags_list ); // WPCS: XSS OK.
    }
  echo '</div><!-- c-post__meta -->';
}
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function ramza_categorized_blog() {
  if ( false === ( $all_the_cool_cats = get_transient( 'ramza_categories' ) ) ) {
    // Create an array of all the categories that are attached to posts.
    $all_the_cool_cats = get_categories( array(
      'fields'     => 'ids',
      'hide_empty' => 1,

      // We only need to know if there is more than one category.
      'number'     => 2,
    ) );

    // Count the number of categories that are attached to the posts.
    $all_the_cool_cats = count( $all_the_cool_cats );

    set_transient( 'ramza_categories', $all_the_cool_cats );
  }

  if ( $all_the_cool_cats > 1 ) {
    // This blog has more than 1 category so ramza_categorized_blog should return true.
    return true;
  } else {
    // This blog has only 1 category so ramza_categorized_blog should return false.
    return false;
  }
}

/**
 * Flush out the transients used in ramza_categorized_blog.
 */
function ramza_category_transient_flusher() {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }
  // Like, beat it. Dig?
  delete_transient( 'ramza_categories' );
}
add_action( 'edit_category', 'ramza_category_transient_flusher' );
add_action( 'save_post',     'ramza_category_transient_flusher' );


if ( ! function_exists( 'ramza_print_post_thumbnail' ) ) :
/**
 * Prints custom the_post_thumbnail().
 *
 * @since 1.0.0
 *
 * @param  string $size Post thumbnail size.
 */
function ramza_print_post_thumbnail( $size = '' ) {
  if ( ! has_post_thumbnail() ) {
    return;
  }

  echo '<div class="c-featured-format">';
    if ( is_singular() ) {
      the_post_thumbnail( $size );
    }
    else {
      echo '<a href="' . esc_url( get_permalink() ) . '">';
        the_post_thumbnail( $size );
      echo '</a>';
    }
  echo '</div><!-- c-featured-format -->';
}
endif;


if ( ! function_exists( 'ramza_print_post_author' ) ) :
/**
 * Print post author info on single blog post page.
 *
 * @since 1.0.0
 */
function ramza_print_post_author() {
  if ( 'post' !== get_post_type() ) {
    return;
  }

  global $post;

  $author_ID = $post->post_author;
  $avatar    = get_avatar( $author_ID, 80 );
  $name      = get_the_author_meta( 'display_name', $author_ID );
  $desc      = get_the_author_meta( 'description', $author_ID );
  $posts_url = get_author_posts_url( $author_ID );

  // HTML
  $html  = '<div class="c-post-author o-box o-box--content">';
    $html .= '<div class="c-post-author__info">';
      $html .= '<div class="c-post-author__avatar">' . $avatar . '</div>';
      $html .= '<h3 class="c-post-author__name">';
        $html .= '<a href="' . esc_url( $posts_url ) . '">' . esc_html( $name ) . '</a>';
      $html .= '</h3>';
      $html .= '<div class="c-post-author__desc">' . $desc . '</div>';
    $html .= '</div><!-- .c-post-author__meta -->';
  $html .= '</div><!-- .c-post-author -->';

  echo $html;
}
endif;


if ( ! function_exists( 'ramza_print_the_content' ) ) :
/**
 * Print custom the_content(). Combines excerpt, read more link
 * and the content into one function.
 *
 * - Prints automatically trimmed excerpt from the content as default.
 * - If read more tag is set, prints the content and read more tag.
 * - If custom excerpt is set, prints custom excerpt.
 *
 * Also includes wp_link_pages().
 * @see   https://codex.wordpress.org/Function_Reference/wp_link_pages
 *
 * @since 1.0.0
 */
function ramza_print_the_content() {
  global $post;

  // Posts loop pages
  if ( is_home() || is_archive() || is_search() ) {
    if ( strpos( $post->post_content, '<!--more-->' ) ) {
      the_content( '' );
      echo '<div class="c-read-more"><a class="o-btn o-btn--small" href="' . esc_url( get_permalink() ) . '">Read More</a></div>';
    }
    else {
      the_excerpt();
    }
  }
  // Singular pages
  else {
    the_content();

    wp_link_pages( array(
      'before'   => '<div class="c-post__pages">' . esc_html__( 'Pages', 'ramza' ) . ':',
      'after'    => '</div><!-- .c-post__pages -->',
      'pagelink' => '<span class="c-post__page">%</span>'
    ) );
  }
}
endif;


if ( ! function_exists( 'ramza_print_posts_nav' ) ) :
/**
 * Display posts navigation when available.
 *
 * @since 1.0.0
 *
 * @todo Check this function when WordPress 4.3 is released.
 *
 * @param int $max_pages Max number of pages of WP Query.
 */
function ramza_print_posts_nav( $max_pages = '' ) {
  // Do not print if Jetpack Infinite Scroll is active
  if ( Jetpack::is_module_active( 'infinite-scroll' ) ) {
    return;
  }

  // If no custom WP query is set, use global WP query
  if ( '' === $max_pages ) {
    $max_pages = $GLOBALS['wp_query']->max_num_pages;
  }

  // Do nothing if there's only one page.
  if ( $max_pages < 2 ) {
    return;
  }

  // Print HTML
  ?>
  <nav class="c-posts-nav" role="navigation">
    <h2 class="u-screen-reader-text"><?php esc_html_e( 'Posts navigation', 'ramza' ); ?></h2>
    <div class="c-posts-nav__links">
      <?php if ( get_next_posts_link( '', $max_pages ) ) : ?>
      <div class="c-posts-nav__link c-posts-nav__link--prev"><?php next_posts_link( esc_html__( 'Older Posts', 'ramza' ), $max_pages ); ?></div>
      <?php endif; ?>
      <?php if ( get_previous_posts_link() ) : ?>
      <div class="c-posts-nav__link c-posts-nav__link--next"><?php previous_posts_link( esc_html__( 'Newer Posts', 'ramza' ) ); ?></div>
      <?php endif; ?>
    </div>
  </nav><!-- .c-posts-nav -->
  <?php
}
endif;


if ( ! function_exists( 'ramza_print_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @since  1.0.0
 */
function ramza_print_post_navigation() {
  // Don't print empty markup if there's nowhere to navigate.
  $prev = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
  $next     = get_adjacent_post( false, '', false );

  if ( ! $next && ! $prev ) {
    return;
  }
  ?>
  <nav class="c-nav-post o-box o-box--content" role="navigation">
    <h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'ramza' ); ?></h2>
    <div class="c-nav-post__links">
      <?php if ( $prev ) : ?>
      <div class="c-nav-post__prev">
        <span><?php esc_html_e( 'Previous Post', 'ramza' ) ?></span>
        <h5 class="c-nav-post__prev-title"><?php previous_post_link( '%link', '%title' ); ?></h5>
      </div>
      <?php endif; ?>
      <?php if ( $next ) : ?>
      <div class="c-nav-post__next">
        <span><?php esc_html_e( 'Next Post', 'ramza' ) ?></span>
        <h5 class="c-nav-post__next-title"><?php next_post_link( '%link', '%title' ); ?></h5>
      </div>
      <?php endif; ?>
    </div><!-- .c-nav-post__links -->
  </nav><!-- .c-nav-post -->
  <?php
}
endif;


if ( ! function_exists( 'ramza_print_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @since  1.0.0
 */
function ramza_print_post_nav() {
  // Don't print empty markup if there's nowhere to navigate.
  $prev = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
  $next     = get_adjacent_post( false, '', false );

  if ( ! $next && ! $prev ) {
    return;
  }
  ?>
  <nav class="c-post-nav o-box o-box--content" role="navigation">
    <h2 class="u-screen-reader-text"><?php esc_html_e( 'Post navigation', 'ramza' ); ?></h2>
    <div class="c-post-nav__links">
      <?php if ( $prev ) : ?>
      <div class="c-post-nav__link c-post-nav__link--prev">
        <span><?php _e( 'Previous Post', 'ramza' ); ?></span>
        <h5><?php previous_post_link( '%link', '%title' ); ?></h5>
      </div>
      <?php endif; ?>
      <?php if ( $next ) : ?>
      <div class="c-post-nav__link c-post-nav__link--next">
        <span><?php _e( 'Next Post', 'ramza' ); ?></span>
        <h5><?php next_post_link( '%link', '%title' ); ?></h5>
      </div>
      <?php endif; ?>
    </div><!-- .c-nav-post__links -->
  </nav><!-- .c-nav-post -->
  <?php
}
endif;


if ( ! function_exists( 'ramza_print_comments_nav' ) ) :
/**
 * Prints comments navigation.
 *
 * @since 1.0.0
 */
function ramza_print_comments_nav() {
   // Are there comments to navigate through?
  if ( get_comment_pages_count() < 1 && ! get_option( 'page_comments' ) ) {
    return;
  }

  ?>
    <nav id="comments-nav" class="c-comments-nav" role="navigation">
      <span class="u-screen-reader-text"><?php esc_html_e( 'Comment navigation', 'ramza' ); ?></span>
      <div class="c-comments-nav__links">
        <div class="c-comments-nav__link c-comments-nav__link--prev"><?php previous_comments_link( esc_html__( 'Older Comments', 'ramza' ) ); ?></div>
        <div class="c-comments-nav__link c-comments-nav__link--next"><?php next_comments_link( esc_html__( 'Newer Comments', 'ramza' ) ); ?></div>
      </div><!-- .c-comment-nav__links -->
    </nav><!-- c-comment-nav -->
  <?php
}
endif;


if ( ! function_exists( 'ramza_list_comments' ) ) :
/**
 * Prints custom comments list.
 *
 * @since 1.0.0
 */
function ramza_list_comments( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;

  if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

  <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'c-comment' ); ?>>
    <div class="c-comment__body">
      <?php esc_html_e( 'Pingback:', 'ramza' ); ?>
      <?php comment_author_link(); ?>
      <?php edit_comment_link( esc_html__( 'Edit', 'ramza' ), '<span class="edit-link">', '</span>' ); ?>
    </div><!-- .comment-body-->
  </li>

  <?php else : ?>

  <?php
    /**
     * Classes to add to comment li tag.
     */
    $comment_classes = 'c-comment';
    $comment_classes .= empty( $args['has_children'] ) ? '' : ' comment-parent';
  ?>

  <li id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment_classes ); ?>>
    <article id="div-comment-<?php comment_ID(); ?>" class="c-comment__body">

      <div class="c-comment__avatar">
        <?php echo get_avatar( $comment, 60 ); ?>
      </div>

      <header class="c-comment__header">
        <div class="c-comment__meta vcard">
          <span class="c-comment__author-name"><?php echo get_comment_author_link(); ?></span>

          <div class="c-comment__date">
            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
              <time datetime="<?php comment_time( 'c' ); ?>">
                <?php
                printf(
                  esc_html_x( '%1$s at %2$s', '1: comment post date, 2: comment post time', 'ramza' ),
                  get_comment_date(),
                  get_comment_time()
                );
                ?>
              </time>
            </a>
          </div><!-- .comment-date -->
        </div><!-- .comment-meta -->


        <?php if ( '0' == $comment->comment_approved ) : ?>
        <p class="c-comment__awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'ramza' ); ?></p>
        <?php endif; ?>
      </header><!-- .comment-header -->


      <div class="c-comment__content">
        <?php comment_text(); ?>

        <?php
          comment_reply_link( array_merge( $args, array(
            'add_below' => 'div-comment',
            'depth'     => $depth,
            'max_depth' => $args['max_depth'],
            'before'    => '<div class="c-comment__reply">',
            'after'     => '</div>',
          ) ) );
        ?>
      </div><!-- .comment-content -->
    </article>
  </li>

  <?php endif;
}
endif;


if ( ! function_exists( 'ramza_comment_form' ) ) :
/**
 * Print custom comment form.
 *
 * @since 1.0.0
 */
function ramza_comment_form() {

  $commenter = wp_get_current_commenter();
  $req       = get_option( 'require_name_email' );
  $aria_req  = ( $req ? " aria-required='true'" : '' );

  $placeholder_author   = esc_html__( 'Name', 'ramza' );
  $placeholder_email    = esc_html__( 'Email', 'ramza' );
  $placeholder_url      = esc_html__( 'Website', 'ramza' );
  $placeholder_comment  = esc_html__( 'Comment', 'ramza' );


  // custom inputs
  $fields = array(
    'author' =>
      '<div class="c-comment-form__author">
        <input id="author" name="author" class="c-comment-form__control" type="text" placeholder="' . $placeholder_author . ( $req ? '*' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' />
      </div>',

    'email' =>
      '<div class="c-comment-form__email">
      <input id="email" name="email" class="c-comment-form__control" type="text" placeholder="' . $placeholder_email . ( $req ? '*' : '' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $aria_req . ' />
      </div>',

    'url' =>
      '<div class="c-comment-form__url">
        <input id="url" name="url" class="c-comment-form__control" type="text" placeholder="' . $placeholder_url . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" />
      </div>',
  );

  // custom textarea
  $comment_field =
    '<div class="c-comment-form__comment">
      <textarea id="comment" name="comment" class="c-comment-form__textarea" placeholder="' . $placeholder_comment .  ( $req ? '*' : '' ) . '"aria-required="true" rows="6"></textarea>
    </div>';


  $comment_form_args = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
    'comment_field'        => $comment_field,
    'comment_notes_before' => '',
    'comment_notes_after'  => '',
    'label_submit'         => esc_html__( 'Post Comment', 'ramza' ),
    'title_reply'          => esc_html__( 'Leave a Comment', 'ramza' ),
    'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'ramza'),
  );


  /**
   * Hack and add CSS classes as WP has not supported
   * functionality to do so cleanly (yet?).
   *
   * @since   1.0.0
   */
  // Cache comment form
  ob_start();
  comment_form( $comment_form_args );
  $comment_form_html = ob_get_clean();
  $o_box_mod = is_page_template( 'page-templates/full-width.php' ) ? 'full' : 'content';

  // Replace outer most container class
  $comment_form_html = str_replace( 'class="comment-respond"', 'class="c-comment-respond o-box o-box--' . $o_box_mod . '"', $comment_form_html );
  // Replace reply title class
  $comment_form_html = str_replace( 'class="comment-reply-title"', 'class="comment-reply-title c-comment-respond__reply-title"', $comment_form_html );
  // Add cancel reply class
  $comment_form_html = str_replace( 'id="cancel-comment-reply-link"', 'id="cancel-comment-reply-link" class="c-comment-respond__cancel-reply"', $comment_form_html );
  // Replace comment form class
  $comment_form_html = str_replace( 'class="comment-form"', 'class="c-comment-form"', $comment_form_html );


  echo $comment_form_html;
}
endif;

