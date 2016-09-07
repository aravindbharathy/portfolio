<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>
<!-- entries -->
	<div id="entries-full">
<!-- breadcrumbs -->
	<div id="breadcrumbs">
		<?php simplenotes_get_breadcrumbs(); ?><div class="clear"></div>
	</div>
<!-- /breadcrumbs -->
	<?php if ( have_posts () ) : while (have_posts()):the_post();?>
<!-- calling entry -->
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry">
		<h2><?php the_title(); ?></h2>
		<div class="clear"></div>
		<div class="contents">
			<?php the_content(); ?>
			<div class="clear"></div>
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
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
	<?php comments_template(); ?>
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
<?php get_footer(); ?>