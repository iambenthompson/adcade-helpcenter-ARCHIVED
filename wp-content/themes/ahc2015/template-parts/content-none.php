<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adcade Help Center 2015
 */

?>

<section class="no-results not-found">
	<header class="page-header"><?php 
		$custom_title = "";
		if (is_search())
		{
			$nothing_found_snippet_id = 497;
			$nothing_found_snippet = get_post($nothing_found_snippet_id);
			$custom_title = get_field('custom_title', $nothing_found_snippet_id);
			global $post;
			$post = $nothing_found_snippet;
			setup_postdata($post);
		}?>
		<h1 class="page-title"><?php if(empty($custom_title)) esc_html_e( 'Nothing Found', 'ahc2015' ); else echo $custom_title; ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'ahc2015' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<?php echo apply_filters('the_content', $post->post_content); ?>
			<?php //get_search_form(); ?>
			<?php wp_reset_postdata(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ahc2015' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
