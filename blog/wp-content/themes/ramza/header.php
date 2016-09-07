<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @since   1.0.0
 * @package ramza
 */

$media_m = 800;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed b-site">
  <a class="skip-link u-screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ramza' ); ?></a>

  <header id="masthead" class="b-site__header" role="banner">
    <div class="o-container">
    <?php get_template_part( 'template-parts/brand', '' ); ?>
    </div><!-- .o-container -->
  </header><!-- .b-site-header -->

  <?php get_template_part( 'template-parts/nav', 'primary' ); ?>

  <div class="o-container">
    <div id="content" class="b-site__content">
