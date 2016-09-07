<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
	<link href="http://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Roboto:400" rel="stylesheet" type="text/css">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_enqueue_script('jquery'); ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper">

<!-- header -->
	<header>
		<h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
	</header>
<!-- /header -->

<!-- extra -->
	<div id="extra">

<!-- network -->
	<div id="network">
		<a id="rss" href="<?php bloginfo('rss2_url'); ?>" title="RSS">RSS</a>
	 <?php $options = get_option( 'simplenotes_theme_options' ); ?>
		<?php if ( $options['instagramurl'] != '' ) : ?>
		<a id="instagram" title="Instagram" href="<?php echo $options['instagramurl']; ?>">Instagram</a>
		<?php endif; ?>
		<?php if ( $options['twitterurl'] != '' ) : ?>
		<a id="twitter" title="Twitter" href="<?php echo $options['twitterurl']; ?>">Twitter</a>
		<?php endif; ?>
		<?php if ( $options['linkedinurl'] != '' ) : ?>
		<a id="linkedin" title="Linkedin" href="<?php echo $options['linkedinurl']; ?>">Facebook</a>
		<?php endif; ?>
		<?php if ( $options['facebookurl'] != '' ) : ?>
		<a id="facebook" title="Facebook" href="<?php echo $options['facebookurl']; ?>">Facebook</a>
		<?php endif; ?>
		<div class="clear"></div>
	</div>
<!-- /network -->

<!-- search -->
	<div id="search">
		<?php get_search_form(); ?><div class="clear"></div>
	</div>
<!-- /search -->

		<div class="clear"></div>
	</div>
<!-- /extra -->

<!-- navigation -->
	<nav id="menu">
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<?php wp_nav_menu( array( 'menu' => 'Primary Navigation', 'container_id' => '', 'depth' => '2', 'menu_class' => '', 'theme_location' => 'primary' ) ); ?>
	<?php else: ?>
	<ul><?php wp_list_pages('sort_column=menu_order&sort_order=asc&title_li=&depth=2'); ?></ul>
	<?php endif; ?>
		<div class="clear"></div>
	</nav>
<!-- /navigation -->
<!-- calling main -->
	<main>