<?php get_header(); ?>
<!-- entries -->
	<div id="entries">
<?php if ( have_posts () ) : while (have_posts()):the_post();?>
<?php endwhile; ?>
<?php else : ?>
	<div class="entry" id="post-<?php the_ID(); ?>">
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