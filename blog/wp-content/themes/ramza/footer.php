<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @since   1.0.0
 * @package ramza
 */


$theme_options = ramza_get_options();
?>
    </div><!-- .b-site-content -->
  </div><!--. o-container -->


  <footer id="colophon" class="b-site__footer o-box" role="contentinfo">
    <div class="o-container">

      <div class="c-copyright">
        <?php echo $theme_options['footer_c-copyright_text']; ?>
      </div><!-- .c-copyright -->

      <?php get_template_part( 'template-parts/nav', 'footer' ); ?>

    </div><!-- .o-container -->
  </footer><!-- b-site-footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
