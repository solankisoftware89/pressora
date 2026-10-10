<?php
/**
 * The main template file
 *
 * This template is used to display content when no specific template is found.
 * It's required in all WordPress themes.
 *
 * @package pressora
 */

get_header();
?>

<main id="primary" class="site-main container">
	<?php
	// Display featured posts on homepage
	if ( is_front_page() || is_home() ) {
        if ( get_theme_mod( 'prssa_show_featured_posts', 'yes' ) === 'yes' ) {
			get_template_part( 'template-parts/featured-posts' );
		}
	}
	
	// Display breadcrumbs on archive pages
	if ( ! is_front_page() && ! is_home() ) {
		prssa_breadcrumbs();
	}
	
    // Get layout option (sourced from Customizer)
    $blog_layout = get_theme_mod( 'prssa_blog_layout', 'grid' );
	?>

    <?php if ( have_posts() ) : ?>

        <?php if ( is_home() && ! is_front_page() ) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php single_post_title(); ?></h1>
            </header>
        <?php endif; ?>

        <div class="post-grid layout-<?php echo esc_attr( $blog_layout ); ?>">
            <?php
            while ( have_posts() ) :
                the_post();

                get_template_part( 'template-parts/content', get_post_type() );

            endwhile;
            ?>
        </div>

        <?php the_posts_navigation(); ?>

    <?php else : ?>

        <?php get_template_part( 'template-parts/content', 'none' ); ?>

    <?php endif; ?>

</main>

<?php
get_sidebar();
get_footer();
