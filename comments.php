<?php
/**
 * The template for displaying comments
 *
 * @package pressora
 */

if ( post_password_required() ) {
	return;
}

$prssa_comment_count = get_comments_number();
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			printf(
				esc_html(
					_nx(
						'%1$s thought on “%2$s”',
						'%1$s thoughts on “%2$s”',
						$prssa_comment_count,
						'comments title',
						'pressora'
					)
				),
				number_format_i18n( $prssa_comment_count ),
				'<span>' . esc_html( get_the_title() ) . '</span>'
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

	<?php
	if ( ! comments_open() && $prssa_comment_count ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'pressora' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->
