<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adcade Help Center 2015
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php 
		$post_type = get_post_type();
		$meta = "";
		$link = get_permalink();
		switch ($post_type)
		{
			case "adscript-api":
				//$meta = " [API: Class]";
				break;
			case "method":
				$adscript_api_ID = get_post_meta(get_the_ID(), "_wpcf_belongs_adscript-api_id")[0];
				$link = post_permalink($adscript_api_ID) . "#" . get_the_title() . "()";
				//$meta = " [API: Method of the " . ahc2015_adscript_link_html($adscript_api_ID) . " Class]";
				break;
			case "property":
				$adscript_api_ID = get_post_meta(get_the_ID(), "_wpcf_belongs_adscript-api_id")[0];
				$link = post_permalink($adscript_api_ID) . "#" . get_the_title();
				//$meta = " [API: Property of the " . ahc2015_adscript_link_html($adscript_api_ID) . " Class]";
				break;
			case "parameter":
				$method_ID = get_post_meta(get_the_ID(), "_wpcf_belongs_method_id")[0];
				$adscript_api_ID = get_post_meta($method_ID, "_wpcf_belongs_adscript-api_id")[0];
				$link = post_permalink(get_post_meta($method_ID, "_wpcf_belongs_adscript-api_id")[0]) . "#" . get_the_title($method_ID) . "()";
				//$meta = " [API: Parameter of the " . ahc2015_adscript_link_html($adscript_api_ID, get_the_title($method_ID), get_the_title($method_ID) . "()") . " Method in the " . ahc2015_adscript_link_html($adscript_api_ID) . " Class]";
				break;
			case "parameter-key":
				$parameter_ID = get_post_meta(get_the_ID(), "_wpcf_belongs_parameter_id")[0];
				$method_ID = get_post_meta($parameter_ID, "_wpcf_belongs_method_id")[0];
				$adscript_api_ID = get_post_meta($method_ID, "_wpcf_belongs_adscript-api_id")[0];
				$link = post_permalink(get_post_meta($method_ID, "_wpcf_belongs_adscript-api_id")[0]) . "#" . get_the_title($method_ID) . "()";
				//$meta = " [API: Part of the " . ahc2015_adscript_link_html($adscript_api_ID, get_the_title($parameter_ID), get_the_title($method_ID) . "()") . " Parameter of the " . ahc2015_adscript_link_html($adscript_api_ID, get_the_title($method_ID), get_the_title($method_ID) . "()") . " Method in the " . ahc2015_adscript_link_html($adscript_api_ID) . " Class]";
				break;
		}
		$meta = " <i> - " . str_replace(home_url(), '', $link) . "</i>"; 
		?>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( $link ) ), '</a>' . $meta . '</h2>' ); ?>

		<?php if ( 'post' == $post_type ) : ?>
		<div class="entry-meta">
			<?php ahc2015_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php ahc2015_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

