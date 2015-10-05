<?php
/**
 * The searchform for our theme.
 *
 * This is the template that displays when a search form is displayed
 *
 * @link https://codex.wordpress.org/Function_Reference/get_search_form
 *
 * @package Adcade Help Center 2015
 */

$search_placeholder = "Search...";
if (is_front_page())
{
	$search_placeholder = "Please enter a search term here.";
}

?><form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( $search_placeholder, 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
	</label>
	<input type="submit" class="search-submit" value="<?php /*echo esc_attr_x( 'Search', 'submit button' ) */?>" />
</form>