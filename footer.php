<?php
/**
 * The template for displaying the footer
 *
 * @package pressora
 */

?>
<footer id="colophon" class="site-footer">

	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<div class="footer-widgets">
			<div class="container">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php
	/**
	 * Footer Copyright
	 * Customizer setting: prssa_footer_copyright
	 */
	$default_copyright = sprintf(
		'&copy; %s %s. %s',
		date_i18n( 'Y' ),
		get_bloginfo( 'name' ),
		esc_html__( 'All rights reserved.', 'pressora' )
	);

	$footer_copyright = get_theme_mod( 'prssa_footer_copyright', $default_copyright );
	?>

	<div class="footer-content">

		<?php
		// Footer social links (must be customizer-based)
		if ( function_exists( 'prssa_display_social_links' ) ) {
			prssa_display_social_links( 'footer' );
		}
		?>
		
		<p class="copyright-text">
			<?php echo wp_kses_post( $footer_copyright ); ?>
		</p>

	</div>
</footer><!-- #colophon -->

<a href="#page" class="back-to-top" title="<?php esc_attr_e( 'Back to top', 'pressora' ); ?>" aria-label="<?php esc_attr_e( 'Back to top', 'pressora' ); ?>">
    <span class="screen-reader-text"><?php esc_html_e( 'Back to top', 'pressora' ); ?></span>
    &#8679;
</a>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
