<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Adcade Help Center 2015
 */

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
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ahc2015' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="header-content">
			<a href="http://www.adcade.com" class="site-branding" rel="author"></a>
			
			<?php 
			if (! ( is_front_page() || is_home() )) :
			?>
				<div id="header-widget-bar" class="" role="complementary">
		   			<?php dynamic_sidebar( 'header-widget-bar' ); ?>
				</div><!-- #header-widget-bar -->
			<?php
			endif;
			?>

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Help Center Menu', 'ahc2015' ); ?></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->
	
	<?php 
	if (! ( is_front_page() || is_home() )) :
		if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb('<p id="breadcrumbs">','</p>');};
	endif; 
	?>

	<div id="content" class="site-content">
