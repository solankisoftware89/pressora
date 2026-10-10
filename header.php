<?php
/**
 * The header for our theme
 *
 * @package pressora
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php
	// Output favicon from Customizer if provided
	$prssa_favicon = get_theme_mod( 'prssa_header_favicon', '' );
	if ( $prssa_favicon ) : ?>
		<link rel="icon" href="<?php echo esc_url( $prssa_favicon ); ?>">
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'pressora' ); ?></a>

	<?php
	/* Sticky Header Setting (stored as 'yes' or 'no') */
	$sticky_header = get_theme_mod( 'prssa_sticky_header', 'no' ) === 'yes' ? ' sticky-enabled' : '';
	?>
	
	<header id="masthead" class="site-header<?php echo esc_attr( $sticky_header ); ?>">
		<div class="container header-inner">
			<?php
			$header_contact = get_theme_mod( 'prssa_header_contact', '' );
			ob_start();
			if ( function_exists( 'prssa_display_social_links' ) ) {
				prssa_display_social_links( 'header' );
			}
			$header_social = trim( ob_get_clean() );
			if ( $header_contact || $header_social || is_customize_preview() ) :
				?>
			<div class="header-top">
				<?php if ( $header_contact || is_customize_preview() ) : ?>
					<?php $tel = preg_replace( '/[^0-9+]/', '', $header_contact ); ?>
					<div class="prssa_header_contact">
						<a href="tel:<?php echo esc_attr( $tel ); ?>">
							<?php echo esc_html( $header_contact ); ?>
						</a>
					</div>
				<?php endif; ?>

				<?php if ( $header_social ) : ?>
					<div class="header-social-wrapper">
						<?php echo $header_social; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<div class="header-main">
				<div class="site-branding">

				<?php
				// =========================================
				// CUSTOM LOGO (Customizer prssa_header_logo)
				// =========================================
				$header_logo = get_theme_mod( 'prssa_header_logo', '' );

				// Logo width & height customizer
				$logo_width  = absint( get_theme_mod( 'prssa_logo_width', 0 ) );
				$logo_height = absint( get_theme_mod( 'prssa_logo_height', 0 ) );

				$logo_styles = array();

				if ( $logo_width ) {
					$logo_styles[] = 'width:' . $logo_width . 'px';
					$logo_styles[] = 'max-width:' . $logo_width . 'px';
				}

				if ( $logo_height ) {
					$logo_styles[] = 'height:' . $logo_height . 'px';
					$logo_styles[] = 'max-height:' . $logo_height . 'px';
				}

				$logo_style_attr = $logo_styles ? ' style="' . esc_attr( implode( ';', $logo_styles ) ) . '"' : '';

				// Show customizer logo if exists
				if ( $header_logo ) :
				?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home">
						<img src="<?php echo esc_url( $header_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>"<?php echo $logo_style_attr; ?>>
					</a>
				<?php
				else :
					// Fallback: default WP logo
					the_custom_logo();
				endif;
				?>


				<?php
				// =========================================
				// SITE TITLE (Customizer: prssa_site_title)
				// =========================================
				$site_title = get_theme_mod( 'prssa_site_title', get_bloginfo( 'name' ) );
				?>
				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php echo esc_html( $site_title ); ?>
						</a>
					</h1>
				<?php else : ?>
					<p class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php echo esc_html( $site_title ); ?>
						</a>
					</p>
				<?php endif; ?>


				<?php
				// =========================================
				// SITE TAGLINE (Customizer: prssa_site_des)
				// =========================================
				$site_desc = get_theme_mod( 'prssa_site_des', get_bloginfo( 'description' ) );

				if ( $site_desc || is_customize_preview() ) :
				?>
					<p class="site-description"><?php echo esc_html( $site_desc ); ?></p>
				<?php endif; ?>

				</div><!-- .site-branding -->

				<nav id="site-navigation" class="main-navigation prssa-menubar" aria-label="<?php esc_attr_e( 'Main menu', 'pressora' ); ?>">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span class="menu-icon" aria-hidden="true"></span>
						<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'pressora' ); ?></span>
					</button>

					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'primary-menu',
							'container'      => false,
							'fallback_cb'    => 'wp_page_menu',
							'walker'         => new prssa_Walker_Nav_Menu(),
						)
					);
					?>
				</nav><!-- #site-navigation -->
			</div>
		</div><!-- .header-inner -->
	</header><!-- #masthead -->
