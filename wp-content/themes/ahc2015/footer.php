<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Adcade Help Center 2015
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-icons centered-icons">
			<a href="https://www.adcade.com/" target="_blank" class="brand"></a>
			<a href="https://www.linkedin.com/company/adcade" target="_blank" class="link">
				<img src="<?php bloginfo('template_directory'); ?>/images/social/linkedin.svg" class="icon">
			</a>
			<a href="https://twitter.com/adcade" target="_blank" class="link">
				<img src="<?php bloginfo('template_directory'); ?>/images/social/twitter.svg" class="icon">
			</a>
			<a href="https://www.facebook.com/adcadenyc" target="_blank" class="link">
				<img src="<?php bloginfo('template_directory'); ?>/images/social/facebook.svg" class="icon">
			</a>
			<a href="https://plus.google.com/+Adcade/videos" target="_blank" class="link">
				<img src="<?php bloginfo('template_directory'); ?>/images/social/google.svg" class="icon">
			</a>
		</div>
		<p class="copyright">© 2015 Adcade. All Rights Reserved.</p>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
