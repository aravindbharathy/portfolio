<?php
/**
 * ramza functions and definitions
 *
 * @since   1.0.0
 * @package ramza
 */

/**
 * The current version of the theme.
 *
 * @since  1.0.0
 */
define( 'RAMZA_VERSION', wp_get_theme()->get( 'Version' ) );

/**
 * Suffix to load unminified assets during development.
 *
 * @since  1.0.0
 */
if ( ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ) {
  define( 'RAMZA_ASSET_SUFFIX', '' );
} else {
  define( 'RAMZA_ASSET_SUFFIX', '.min' );
}


if ( ! function_exists( 'ramza_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since  1.0.0
 */
function ramza_setup() {
  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   * If you're building a theme based on ramza, use a find and replace
   * to change 'ramza' to the name of your theme in all the template files
   */
  load_theme_textdomain( 'ramza', get_template_directory() . '/languages' );

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  /*
   * Let WordPress manage the document title.
   * By adding theme support, we declare that this theme does not use a
   * hard-coded <title> tag in the document head, and expect WordPress to
   * provide it for us.
   */
  add_theme_support( 'title-tag' );

  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  add_theme_support( 'post-thumbnails' );
  add_image_size( 'ramza-content-image', 630, 0 );
  add_image_size( 'ramza-content-image-full', 1080, 0 );

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'primary'        => esc_html__( 'Primary', 'ramza' ),
    'footer'         => esc_html__( 'Footer', 'ramza' ),
    'footer-social'  => esc_html__( 'Footer Social', 'ramza' )
  ) );

  /*
   * Switch default core markup for search form, comment form, and comments
   * to output valid HTML5.
   */
  add_theme_support( 'html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ) );

  // Set up the WordPress core custom background feature.
  add_theme_support( 'custom-background', apply_filters( 'ramza_custom_background_args', array(
    'default-color' => 'eeeeee',
    'default-image' => '',
  ) ) );

  // Add styling to WYSIWYG editor backend
  add_editor_style( array( 'css/editor-style.css' ) );
}
add_action( 'after_setup_theme', 'ramza_setup' );
endif; // ramza_setup


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since  1.0.0
 */
function ramza_set_content_width() {
  $content_width = 1260;
  $GLOBALS['content_width'] = apply_filters( 'ramza_set_content_width', $content_width );
}
add_action( 'after_setup_theme', 'ramza_set_content_width', 0 );


/**
 * Register widget area.
 *
 * @since  1.0.0
 */
function ramza_widgets_init() {
  register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'ramza' ),
    'id'            => 'sidebar-1',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="c-widget o-box o-box--widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h4 class="c-wiget__title">',
    'after_title'   => '</h4>',
  ) );
}
add_action( 'widgets_init', 'ramza_widgets_init' );


/**
 * Enqueue/Register scripts and styles.
 *
 * @since  1.0.0
 */
function ramza_assets() {
  // Libraries
  wp_enqueue_script(
    'ramza-fitvids',
    get_template_directory_uri() . '/lib/jquery.fitvids.js',
    array( 'jquery' ),
    '1.1',
    true
  );
  wp_enqueue_style(
    'ramza-fontawesome',
    get_template_directory_uri() . '/lib/font-awesome/css/font-awesome' . RAMZA_ASSET_SUFFIX . '.css',
    array(),
    '4.4.0'
  );

  // Styles
  wp_enqueue_style(
    'ramza-style',
    get_stylesheet_uri(),
    array(),
    RAMZA_VERSION
  );

  // Scripts
  wp_enqueue_script(
    'ramza-script',
    get_template_directory_uri() . '/js/theme' . RAMZA_ASSET_SUFFIX . '.js',
    array( 'jquery' ),
    RAMZA_VERSION,
    true
  );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'ramza_assets' );


/**
 * Implement the Custom Header feature.
 *
 * @since  1.0.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since  1.0.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 *
 * @since  1.0.0
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Adds main customizer file.
 *
 * @since  1.0.0
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 *
 * @since  1.0.0
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load admin related functions.
 *
 * @since  1.1.0
 */
require get_template_directory() . '/inc/admin/admin.php';
