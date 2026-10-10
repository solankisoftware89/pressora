<?php
/**
 * The template for displaying author archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pressora
 */

get_header();
?>

<main id="primary" class="site-main container">
	<?php
	if ( have_posts() ) :
		the_post();
		?>
		
		<header class="author-archive-header">
			<div class="author-archive-avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 120 ); ?>
			</div>
			<h1 class="author-archive-name"><?php echo esc_html( get_the_author() ); ?></h1>
			<?php if ( get_the_author_meta( 'description' ) ) : ?>
				<div class="author-archive-bio">
					<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
				</div>
			<?php endif; ?>
			<div class="author-stats">
				<span class="author-posts-count">
					<?php
					$post_count = count_user_posts( get_the_author_meta( 'ID' ) );
					printf(
						/* translators: %d: number of posts */
						esc_html( _n( '%d Post', '%d Posts', $post_count, 'pressora' ) ),
						number_format_i18n( $post_count )
					);
					?>
				</span>
			</div>
		</header>

		<?php
		rewind_posts();
		?>

		<div class="post-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			endwhile;
			?>
		</div>

		<div class="pagination-wrap">
			<?php the_posts_navigation(); ?>
		</div>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();


