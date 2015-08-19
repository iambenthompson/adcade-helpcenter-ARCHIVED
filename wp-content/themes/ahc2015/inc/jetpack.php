<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Adcade Help Center 2015
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function ahc2015_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'ahc2015_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function ahc2015_jetpack_setup
add_action( 'after_setup_theme', 'ahc2015_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function ahc2015_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function ahc2015_infinite_scroll_render
