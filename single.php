<?php
/**
 * Template for displaying single posts
 *
 * @package pressora
 */

get_header();
?>

<main id="primary" class="site-main container" role="main">

	<?php
	prssa_breadcrumbs();

	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', get_post_type() );

		if ( get_theme_mod( 'prssa_show_author_bio', 'yes' ) === 'yes' ) {
			prssa_author_bio();
		}

		the_post_navigation(
			array(
				'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'pressora' ) . '</span> <span class="nav-title">%title</span>',
				'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'pressora' ) . '</span> <span class="nav-title">%title</span>',
			)
		);

		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile;
	?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
