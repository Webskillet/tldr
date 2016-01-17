<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 */
?>

		</div></div><!-- #main, .main-wrapper -->

	<div class="footer-wrapper">
		<footer id="footer" class="site-footer clearfix container" role="contentinfo">
			<div class="footer-inner row <?php echo tldr_footer_class(); ?>">

			<?php get_sidebar( 'footer' ); ?>

			<div class="site-info col-xs-12">
				<a href="<?php echo esc_url( __( 'http://www.webskillet.com/', 'tldr' ) ); ?>"><?php printf( __( 'Website by %s | a union shop, worker-owned cooperative and women-owned business', 'tldr' ), 'Webskillet' ); ?></a>
			</div><!-- .site-info -->

			</div><!-- /.footer-inner -->
		</footer><!-- #footer -->
	</div><!-- /.footer-wrapper -->

</div><!-- #wrapper -->

	<?php wp_footer(); ?>
</body>
</html>
