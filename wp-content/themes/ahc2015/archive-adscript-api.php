<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adcade Help Center 2015
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php 
				$api_snippet_id = 569;
				$api_snippet = get_post($api_snippet_id);
				$custom_title = get_field('custom_title', $api_snippet_id);
				global $post;
				$post = $api_snippet;
				setup_postdata($post);
				$custom_content_formatted = apply_filters('the_content', $post->post_content);
				wp_reset_postdata();
			?>

			<header class="page-header">
			<?php 
				if(empty($custom_title)) the_archive_title( '<h1 class="page-title">', '</h1>' ); else echo '<h1 class="page-title">' . $custom_title . '</h1>';
				//the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
			</header><!-- .page-header -->
			<?php echo $custom_content_formatted; ?>
			<?php /* Start the Loop */ 
			$shapes = [];
			$elems = [];
			$others = [];
			$shape_id = 13;
			$elem_id = 84;
			//$first = true;
			while ( have_posts() ) : the_post(); 
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					$ancestors = get_ancestors(get_the_ID(), 'page');
					switch(end($ancestors)){ //Highest ancestor ID
						case $shape_id:
							//Skip ELEM since it will be listed specifically later
							if ($post->ID == $elem_id) break; 
							if (prev($ancestors) == $elem_id)
								$elems[] = $post;
							else
								$shapes[] = $post;
							break;
						default:
							//Skip SHAPE and ELEM since they are more or less reference only
							if ($post->ID == $shape_id || $post->ID == $elem_id) break; 
							
							$others[] = $post;
					}
			endwhile; 
			?>
			<h2>Class List</h2>
			<div id="shapes">
				<h3>Canvas Shapes</h3>
				<ul>
					<li><?php echo ahc2015_adscript_link_html($shape_id); ?>
						<ul>
						<?php
							foreach ($shapes as $shape) {
								echo "<li>" . ahc2015_adscript_link_html($shape->ID) . "</li>";
							}
						?>
						</ul>
					</li>
				</ul>
			</div>
			<div id="elements">
				<h3>Elements</h3>
				<ul>
					<li><?php echo ahc2015_adscript_link_html($elem_id); ?>
						<ul>
						<?php
							foreach ($elems as $elem) {
								echo "<li>" . ahc2015_adscript_link_html($elem->ID) . "</li>";
							}
						?>
						</ul>
					</li>
				</ul>
			</div>
			<div id="others">
				<h3>Utilities / Misc</h3>
				<ul>
				<?php
					foreach ($others as $other) {
						echo "<li>" . ahc2015_adscript_link_html($other->ID) . "</li>";
					}
				?>
				</ul>
			</div>
			<?php the_posts_navigation(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
