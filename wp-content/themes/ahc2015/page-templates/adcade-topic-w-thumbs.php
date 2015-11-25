<?php
/**
 * Template Name: Adcade Topic w/Thumbs
 *
 * @package Adcade Help Center 2015
 */

//Move Thumbnail to front of CC Child Pages for this template
function custom_ccchildpage_inner_template($template) {
    $template = '<div class="ccchildpage {{page_class}}">{{thumbnail}}<h3{{title_class}}>{{title}}</h3>{{excerpt}}{{more}}</div>';
    return $template;
}
add_filter( 'ccchildpages_inner_template' ,'custom_ccchildpage_inner_template' );

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<!-- <h2>Related Content</h2> -->

				<?php echo do_shortcode('[child_pages thumbs="true" link_thumbs="true" truncate_excerpt="true" words="30" link_titles="true" hide_more="false" cols="2" more="More..."]'); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
