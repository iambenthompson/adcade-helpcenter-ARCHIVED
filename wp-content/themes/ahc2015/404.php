<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Adcade Help Center 2015
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<?php 
					$custom_title = "";
					$four_o_four_snippet_id = 1296;
					$four_o_four_snippet = get_post($four_o_four_snippet_id);
					$custom_title = get_field('custom_title', $four_o_four_snippet_id);
					global $post;
					$post = $four_o_four_snippet;
					setup_postdata($post);
					?>
					<h1 class="page-title"><?php if(empty($custom_title)) esc_html_e( 'Oops! That page can&rsquo;t be found.', 'ahc2015' ); else echo $custom_title; ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<?php
					if (empty($post->post_content))
					{?>
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'ahc2015' ); ?></p>
					<?php
					} else {
						echo apply_filters('the_content', $post->post_content);
					}
					wp_reset_postdata();
					?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>