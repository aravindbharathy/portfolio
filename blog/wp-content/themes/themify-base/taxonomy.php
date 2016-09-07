<?php
/**
 * Template for common archive pages, author and search results
 *
 * @package themify
 * @since 1.0.0
 */
?>
<?php get_header(); ?>

	<!-- layout -->
	<div id="layout" class="pagewidth clearfix">

		<!-- content -->
		<?php themify_base_content_before(); //hook ?>
		<div id="content" class="clearfix">
			<?php themify_base_content_start(); //hook ?>

			<?php
			/////////////////////////////////////////////
			// Category Title
			/////////////////////////////////////////////
			?>
                        <h1 class="page-title"><?php single_cat_title(); ?></h1>
                        <?php echo themify_base_get_category_description(); ?>
	

			<?php
			/////////////////////////////////////////////
			// Loop
			/////////////////////////////////////////////
			if ( have_posts() ) : ?>

				<!-- loops-wrapper -->
				<div id="loops-wrapper" class="loops-wrapper">

					<?php while ( have_posts() ) : the_post(); ?>

                                            <?php get_template_part( 'includes/loop', 'index' ); ?>
						
					<?php endwhile; ?>

				</div>
				<!-- /loops-wrapper -->

				<?php get_template_part( 'includes/pagination' ); ?>

			<?php else : ?>

				<?php
				/////////////////////////////////////////////
				// Error - No Page Found
				/////////////////////////////////////////////
				?>

				<p><?php _e( 'Sorry, nothing found.', 'themify' ); ?></p>

			<?php endif; ?>
			<?php themify_base_content_end(); //hook ?>
		</div>
		<?php themify_base_content_after(); //hook ?>
		<!-- /#content -->

		<?php
		/////////////////////////////////////////////
		// Sidebar
		/////////////////////////////////////////////
		get_sidebar(); ?>

	</div>
	<!-- /#layout -->

<?php get_footer(); ?>