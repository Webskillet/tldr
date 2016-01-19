<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 */
?>

		</div></div><!-- #main, .main-wrapper -->

<?php if ( is_active_sidebar( 'prefooter1' ) ) : ?>
<div id="prefooter1-wrapper">
	<div id="prefooter1" class="prefooter1 widget-area clearfix container" role="complementary">
		<div class="prefooter1-inner row">
			<?php dynamic_sidebar( 'prefooter1' ); ?>
		</div>
	</div><!-- #prefooter1 -->
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'prefooter2' ) ) : ?>
<div id="prefooter2-wrapper">
	<div id="prefooter2" class="prefooter2 widget-area clearfix container" role="complementary">
		<div class="prefooter2-inner row">
			<?php dynamic_sidebar( 'prefooter2' ); ?>
		</div>
	</div><!-- #prefooter1 -->
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'utility' ) ) : ?>
<div id="utility-wrapper">
	<div id="utility" class="utility widget-area clearfix container" role="complementary">
		<?php dynamic_sidebar( 'utility' ); ?>
	</div><!-- #primary-sidebar -->
</div>
<?php endif; ?>

	<div id="footer-wrapper">
		<footer id="footer" class="site-footer clearfix container" role="contentinfo">
			<div class="footer-inner">

			<?php if ( is_active_sidebar( 'footer' ) ): ?>

	<div id="footer-widget-area" class="footer-widget-area widget-area row" role="complementary">
		<?php dynamic_sidebar( 'footer' ); ?>
	</div><!-- #footer-widget-area -->

			<?php endif; ?>

			</div><!-- /.footer-inner -->
		</footer><!-- #footer -->
	</div><!-- /.footer-wrapper -->

</div><!-- #wrapper -->

<?php if ( is_active_sidebar( 'modals' ) ) : ?>
<div id="modals-wrapper">
	<div class="modal-dismiss primary fa" title="Dismiss modal"></div>
	<div id="modals" class="modals widget-area" role="complementary">
		<?php dynamic_sidebar( 'modals' ); ?>
	</div><!-- #modals -->
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'reveal-left' ) ) : ?>
<div id="reveal-left-wrapper" class="reveal">
	<div class="reveal-dismiss primary fa" title="Dismiss sidebar"></div>
	<div id="reveal-left" class="reveal-left widget-area" role="complementary">
		<?php dynamic_sidebar( 'reveal-left' ); ?>
	</div><!-- #reveal-left -->
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'reveal-right' ) ) : ?>
<div id="reveal-right-wrapper" class="reveal">
	<div class="reveal-dismiss primary fa" title="Dismiss sidebar"></div>
	<div id="reveal-right" class="reveal-right widget-area" role="complementary">
		<?php dynamic_sidebar( 'reveal-right' ); ?>
	</div><!-- #reveal-right -->
</div>
<?php endif; ?>

	<?php wp_footer(); ?>
</body>
</html>
