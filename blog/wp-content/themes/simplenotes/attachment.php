<?php get_header(); ?>
<!-- entries -->
	<div id="entries">
	<?php if ( have_posts () ) : while (have_posts()):the_post();?>
<!-- entry -->
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry">
	<h2><?php the_title(); ?></h2>
	<div class="clear"></div>
	<div class="contents">
<p>
<?php 
    echo wp_get_attachment_link( $id, 'medium', true ); 
?>
</p>
<?php previous_image_link(); ?> <?php next_image_link();?>
<p><?php edit_post_link('Edit this post', '(', ')'); ?></p>
	</div>
<!-- meta -->
	<div class="meta">
		<div class="time"></div>&nbsp;<?php the_time('F jS, Y') ?>&nbsp;&nbsp;
		<div class="user"></div>&nbsp;<a href="<?php the_author_meta('url'); ?>"><?php the_author(); ?></a>
	</div>
<!-- /meta -->
	</div>
	</div>
<!-- /entry -->
<?php endwhile; ?>
<?php else : ?>
	<div class="entry">
		<h2>404 Not Found</h2>
		<div class="clear"></div>
		<div class="contents">
			<p>Sorry, but you are looking for something that isn't here. </p>
		</div>
	</div>
<?php endif; ?>
	</div>
<!-- /entries -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>