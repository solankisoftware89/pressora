<?php

/**
 * Pressora Theme functions and definitions
 *
 * @package pressora
 */

/**
 * Returns the URL of the placeholder image in the theme's images folder.
 */
function prssa_get_placeholder_image() {
	return get_template_directory_uri() . '/images/placeholder.png';
}

if ( ! defined( 'prssa_VERSION' ) ) {
	define( 'prssa_VERSION', '1.0.10' );
}

/**
 * Theme setup
 */
function prssa_setup() {
	load_theme_textdomain( 'pressora', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support(
		'custom-background',
		apply_filters(
			'prssa_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'pressora' ),
			'footer' => esc_html__( 'Footer Menu', 'pressora' ),
		)
	);

	// Load editor styles
	add_editor_style( 'editor-style.css' );
}
add_action( 'after_setup_theme', 'prssa_setup' );

function prssa_register_block_styles() {
	register_block_style(
		'core/image',
		array(
			'name'  => 'prssa-fancy-border',
			'label' => __( 'Fancy Border', 'pressora' ),
			'inline_style' => '.is-style-prssa-fancy-border { border: 5px double #000; padding: 10px; }',
		)
	);
	register_block_pattern(
		'prssa/hero-text',
		array(
			'title'       => __( 'Hero Text Section', 'pressora' ),
			'description' => _x( 'A centered hero section with text.', 'Block pattern description', 'pressora' ),
			'content'     => "<!-- wp:paragraph {\"align\":\"center\",\"fontSize\":\"large\"} --><p class=\"has-text-align-center has-large-font-size\">" . esc_html__('Welcome to Our Website!', 'pressora') . "</p><!-- /wp:paragraph -->",
		)
	);
}
add_action( 'init', 'prssa_register_block_styles' );

/**
 * Set the content width
 */
function prssa_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'prssa_content_width', 640 );
}
add_action( 'after_setup_theme', 'prssa_content_width', 0 );

/**
 * Register widget area
 */
function prssa_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'pressora' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'pressora' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area', 'pressora' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'pressora' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'prssa_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function prssa_scripts() {
	wp_enqueue_style( 'prssa-style', get_stylesheet_uri(), array(), prssa_VERSION );
	wp_style_add_data( 'prssa-style', 'rtl', 'replace' );

	wp_enqueue_script(
		'prssa-navigation',
		get_template_directory_uri() . '/js/navigation.js',
		array(),
		prssa_VERSION,
		true
	);

	wp_enqueue_script(
		'prssa-custom',
		get_template_directory_uri() . '/js/custom.js',
		array(),
		prssa_VERSION,
		true
	);

	if ( is_customize_preview() ) {
		wp_enqueue_script(
			'prssa-customizer',
			get_template_directory_uri() . '/js/customizer.js',
			array( 'jquery', 'customize-preview' ),
			prssa_VERSION,
			true
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'prssa_scripts' );

/**
 * Custom Navigation Walker for better accessibility
 */
class prssa_Walker_Nav_Menu extends Walker_Nav_Menu {

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

        // Normalize args (PHP 8 fix)
        if ( is_array( $args ) ) {
            $args = (object) $args;
        }

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        if ( in_array( 'menu-item-has-children', $classes, true ) ) {
            $classes[] = 'has-children';
        }

        $class_names = implode(
            ' ',
            apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args )
        );

        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $item_id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
        $item_id = $item_id ? ' id="' . esc_attr( $item_id ) . '"' : '';

        $output .= $indent . '<li' . $item_id . $class_names . '>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="' . esc_url( $item->url ) . '"' : '';

        if ( in_array( 'menu-item-has-children', $classes, true ) ) {
            $attributes .= ' aria-haspopup="true" aria-expanded="false"';
        }

        $item_output  = $args->before ?? '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ( $args->link_before ?? '' )
            . apply_filters( 'the_title', $item->title, $item->ID )
            . ( $args->link_after ?? '' );
        $item_output .= '</a>';

        if ( in_array( 'menu-item-has-children', $classes, true ) ) {
            $item_output .= ' <span class="submenu-toggle" role="button" tabindex="0" aria-expanded="false" aria-label="'
                . esc_attr__( 'Toggle submenu', 'pressora' ) . '"></span>';
        }

        $item_output .= $args->after ?? '';

        $output .= apply_filters(
            'walker_nav_menu_start_el',
            $item_output,
            $item,
            $depth,
            $args
        );
    }
}


/**
 * Include theme files
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/blog-functions.php';
require get_template_directory() . '/inc/theme-colors.php';

if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

