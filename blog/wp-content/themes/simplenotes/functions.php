<?php
add_theme_support( 'title-tag' );
// ********************************* SF *********************************
function simplenotes_alter_search_form( $form ){
return '<form role="search" method="get" id="search-form" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
		<div>
				<label class="screen-reader-text" for="s">Search for:</label>
				<input type="text" placeholder="Enter keyword" autocomplete="off" value="" name="s" id="s" />
				<input type="submit" id="searchsubmit" value="Search" />
		</div>
</form>';
}
add_filter( 'get_search_form', 'simplenotes_alter_search_form', 99999 );
?>
<?php
function theme_styles()  
{
  wp_register_style( 'simplenotes-style', 
    get_template_directory_uri() . '/style.css', 
    array(), 
    '4.2', 
    'all' );
  // enqueing:
  wp_enqueue_style( 'simplenotes-style' );
}
add_action('wp_enqueue_scripts', 'theme_styles');
// ********************************* CS *********************************
function simplenotes_load_scripts() {
	if ( !is_admin() ) {  
		wp_register_script('simplenotes_custom_script', get_template_directory_uri() . '/js/scroll.js', array('jquery') );
		wp_enqueue_script('simplenotes_custom_script');
		wp_register_script('simplenotes_custom_script2', get_template_directory_uri() . '/js/custom.js', array('jquery') );
		wp_enqueue_script('simplenotes_custom_script2');
	}
}
add_action('init', 'simplenotes_load_scripts');
?>
<?php
add_theme_support('post-thumbnails');
add_theme_support('automatic-feed-links');
if ( ! isset( $content_width ) ) $content_width = 620;
// ********************************* MN *********************************
add_action( 'init', 'simplenotes_register_menus' );
function simplenotes_register_menus() {
register_nav_menus( array(
'primary' => __( 'Primary Navigation', 'Simplenotes' ),
) );
}
// ********************************* WG *********************************
add_action( 'widgets_init', 'simplenotes_widgets_init' );
function simplenotes_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Sidebar', 'simplenotes' ),
        'id' => 'sidebar',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'simpletons' ),
        'before_widget' => '<div class="sidebar">',
	'after_widget'  => '</div>',
	'before_title'  => '<h3>',
	'after_title'   => '</h3>',
    ) );
}
?>
<?php
// ********************************* TC *********************************
if ( ! function_exists( 'simplenotes_comment' ) ) :
function simplenotes_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div class="comments" id="comment-<?php comment_ID(); ?>">
		<div class="commentsData">
			<div class="gravatar"><?php echo get_avatar( $comment, 50 ); ?></a></div>
		<div class="author">
				<div class="authorName"><?php comment_author_link() ?></div>
				<div class="authordate"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( __( '%1$s at %2$s', 'Simplenotes' ), get_comment_date(),  get_comment_time() ); ?></a> <?php edit_comment_link( __( '(Edit)', 'Simplenotes' ), ' ' ); ?></div>
	</div>
<div class="clear"></div>
		</div>
		<div class="commented"><?php comment_text(); ?>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em>Your comment is awaiting moderation.</em>
			<br />
		<?php endif; ?>
		</div>
		<div class="reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
<div class="clear"></div>
	</div>
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p>Pingback: <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'Simplenotes'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;
// ********************************* BC *********************************
function simplenotes_get_breadcrumbs()
{
	global $wp_query; 
	if ( !is_home() ){
		// Start the UL
		echo '<ul>';
		// Add the Home link
		echo '<li><a href="'. home_url() .'">'. get_bloginfo('name') .'</a></li>';
		if ( is_category() ) 
		{
			$catTitle = single_cat_title( "", false );
			$cat = get_cat_ID( $catTitle );
			echo "<li> &nbsp; &#9658; ". get_category_parents( $cat, TRUE, " &#9658; " ) ."</li>";
		}
		elseif ( is_archive() && !is_category() ) 
		{
			echo "<li> &nbsp; &#9658; Archives</li>";
		}
		elseif ( is_single() ) 
		{
			$category = get_the_category();
			$category_id = get_cat_ID( $category[0]->cat_name );
			echo '<li> &nbsp; &#9658; '. get_category_parents( $category_id, TRUE, "</li><li> &nbsp; &#9658; " );
			echo the_title('','', FALSE) ."</li>";
		}
		elseif ( is_page() ) 
		{
			$post = $wp_query->get_queried_object(); 
			if ( $post->post_parent == 0 ){ 
				echo "<li>&nbsp; &#9658; ".the_title('','', FALSE)."</li>";
			} else {
				$title = the_title('','', FALSE);
				$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
				array_push($ancestors, $post->ID);
 
				foreach ( $ancestors as $ancestor ){
					if( $ancestor != end($ancestors) ){
						echo '<li>&nbsp; &#9658; <a href="'. get_permalink($ancestor) .'">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</a></li>';
					} else {
						echo '<li>&nbsp; &#9658; '. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</li>';
					}
				}
			}
		}
		// End the UL
		echo "</ul>";
	}
}
?>
<?php
// ********************************* OP *********************************
add_action( 'admin_init', 'simplenotes_options_init' );
add_action( 'admin_menu', 'simplenotes_options_add_page' );
function simplenotes_options_init(){
	register_setting( 'simplenotes_options', 'simplenotes_theme_options', 'simplenotes_options_validate' );
}
function simplenotes_options_add_page() {
	add_theme_page( __( 'Theme Options', 'simplenotes' ), __( 'Theme Options', 'simplenotes' ), 'edit_theme_options', 'theme_options', 'simplenotes_options_do_page' );
}
function simplenotes_options_do_page() {
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	?>
	<div class="wrap">
		<?php echo "<h2>" . wp_get_theme() . __( ' Theme Options', 'simplenotes' ) . "</h2>"; ?>
		<p><?php _e( 'These options will let you setup the social icons at the top of the theme and your link and navigation colours. You can enter the URLs of your profiles to have the icons show up.', 'simplenotes' ); ?></p>
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'simplenotes' ); ?></strong></p></div>
		<?php endif; ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'simplenotes_options' ); ?>
			<?php $options = get_option( 'simplenotes_theme_options' ); ?>
			<table class="form-table">
				<tr valign="top"><th scope="row"><?php _e( 'Facebook', 'simplenotes' ); ?></th>
					<td>
						<input id="simplenotes_theme_options" class="regular-text" type="text" name="simplenotes_theme_options[facebookurl]" value="<?php esc_attr_e( $options['facebookurl'] ); ?>" />
						<label class="description" for="mon_cahier_theme_options[facebookurl]"></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Twitter', 'simplenotes' ); ?></th>
					<td>
						<input id="simplenotes_theme_options" class="regular-text" type="text" name="simplenotes_theme_options[twitterurl]" value="<?php esc_attr_e( $options['twitterurl'] ); ?>" />
						<label class="description" for="simplenotes_theme_options[twitterurl]"></label>
					</td>
				</tr>


				<tr valign="top"><th scope="row"><?php _e( 'Instagram', 'simplenotes' ); ?></th>
					<td>
						<input id="simplenotes_theme_options" class="regular-text" type="text" name="simplenotes_theme_options[instagramurl]" value="<?php esc_attr_e( $options['instagramurl'] ); ?>" />
						<label class="description" for="simplenotes_theme_options[instagramurl]"></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Linkedin', 'simplenotes' ); ?></th>
					<td>
						<input id="simplenotes_theme_options" class="regular-text" type="text" name="simplenotes_theme_options[linkedinurl]" value="<?php esc_attr_e( $options['linkedinurl'] ); ?>" />
						<label class="description" for="simplenotes_theme_options[linkedinurl]"></label>
					</td>
				</tr>

			</table>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'simplenotes' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}
function simplenotes_options_validate( $input ) {
	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['hiderss'] ) )
		$input['hiderss'] = null;
		$input['hiderss'] = ( $input['hiderss'] == 1 ? 1 : 0 );
	$input['twitterurl'] = wp_filter_nohtml_kses( $input['twitterurl'] );
	$input['facebookurl'] = wp_filter_nohtml_kses( $input['facebookurl'] );
	$input['instagramurl'] = wp_filter_nohtml_kses( $input['instagramurl'] );
	$input['linkedinurl'] = wp_filter_nohtml_kses( $input['linkedinurl'] );
	$input['twitterurl'] = esc_url_raw( $input['twitterurl'] );
	$input['facebookurl'] = esc_url_raw( $input['facebookurl'] );
	$input['instagramurl'] = esc_url_raw( $input['instagramurl'] );
	$input['linkedinurl'] = esc_url_raw( $input['linkedinurl'] );
	return $input;
}
?>