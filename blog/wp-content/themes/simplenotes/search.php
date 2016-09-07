	<?php get_header(); ?>
<!-- entries -->
	<div id="entries">
		<?php if ( have_posts () ) : while (have_posts()):the_post();?>
<!-- entry -->
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry">
<!-- date -->
	<div class="date">
	<div class="month"><?php the_time('M') ?></div>
	<div class="day"><?php the_time('d') ?></div>
	</div>
<!-- /date -->
		<h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="clear"></div>
		<div class="contents">
			<?php the_content(); ?>
			<div class="clear"></div>
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</div>
<!-- meta -->
	<div class="meta">
		<div class="time"></div>&nbsp;<?php the_time('F jS, Y') ?>&nbsp;&nbsp;
		<div class="user"></div>&nbsp;<a href="<?php the_author_meta('url'); ?>"><?php the_author(); ?></a>&nbsp;&nbsp;
		<div class="category"></div>&nbsp;<?php the_category(', ', '' ); ?>&nbsp;&nbsp;
		<div class="tag"></div>&nbsp;<?php the_tags('', ', ', ''); ?>&nbsp;&nbsp;
		<div class="comment"></div>&nbsp;<?php comments_popup_link('0 Comment','1 Comment','% Comments'); ?>
	</div>
<!-- /meta -->
	</div>
	</div>
<!-- /entry -->
	<?php endwhile; ?>
	<div id="pagination">
		<?php posts_nav_link('&nbsp;&nbsp;&nbsp;', 'Newer', 'Older'); ?>
	</div>
	<?php else : ?>
		<div class="entry">
			<h2>404 Not Found</h2>
			<div class="clear"></div>
			<div class="contents">
				<p>Sorry, but you are looking for something that isn't here.</p>
			</div>
		</div>
	<?php endif; ?>
	</div>
<!-- /entries -->
	<?php get_sidebar(); ?>
	<?php get_footer(); ?>