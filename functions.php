<?php
/**
 * Silence is golden; exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bootstrap CMB2
 */
require_once 'inc/cmb2/init.php';

/**
 * Load the CMB2 powered theme options page
 */
require_once 'inc/theme-options.php';

if ( ! function_exists( 'cmb2_example_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since 1.0
 */
function cmb2_example_theme_setup() {
	global $content_width;

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Register our primary menu
	 */
	register_nav_menu( 'primary', __( 'Primary Menu', 'cmb2-example-theme' ) );

	/**
	 * Register sidebar widget area
	 */
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'cmb2-example-theme' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'cmb2-example-theme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	/**
	 * Register however many footer widgets our options say to
	 */
	$footer_widgets = absint( cmb2_example_theme_get_option( 'footer_widget_areas' ) );
	register_sidebars( $footer_widgets, array(
		'name'          => __( 'Footer %d', 'cmb2-example-theme' ),
		'id'            => 'footer',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'cmb2-example-theme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	/**
	 * Set the content width to our options content width
	 */
	if ( ! isset( $content_width ) ) {
		$site_width = 0 < absint( cmb2_example_theme_get_option( 'width' ) ) ? absint( cmb2_example_theme_get_option( 'width' ) ) : 960;
		$content_width = absint( cmb2_example_theme_get_option( 'width' ) / 1.62 );
	}
}
endif;
add_action( 'after_setup_theme', 'cmb2_example_theme_setup' );


/**
 * Enqueue scripts and styles.
 *
 * @since 1.0
 */
function cmb2_example_theme_scripts() {
	global $content_width;

	wp_enqueue_style( 'cmb2-example-theme', get_stylesheet_uri() );

	/**
	 * Add theme custom CSS from theme options
	 */
	$site_width = 0 < absint( cmb2_example_theme_get_option( 'width' ) ) ? absint( cmb2_example_theme_get_option( 'width' ) ) : 960;
	$content_width = $content_width;

	$sidebar_float = cmb2_example_theme_get_option( 'sidebar_position' );
	$content_float = 'right' == $sidebar_float ? 'left' : 'right';

	$bg_color = ! empty( cmb2_example_theme_get_option( 'bg_color' ) ) ? cmb2_example_theme_get_option( 'bg_color' ) : '#404040';
	$content_bg_color = ! empty( cmb2_example_theme_get_option( 'content_bg_color' ) ) ? cmb2_example_theme_get_option( 'content_bg_color' ) : '#ffffff';

	ob_start();
	?>
body {
	background: <?php echo $bg_color; ?>;
}

#page {
	width: <?php echo $site_width; ?>px;
	background: <?php echo $content_bg_color; ?>;
}

#primary {
	width: <?php echo $content_width; ?>px;
	float: <?php echo $content_float; ?>;
}

#secondary {
	width: <?php echo $site_width - $content_width; ?>px;
	float: <?php echo $sidebar_float; ?>;
}
	<?php
	wp_add_inline_style( 'cmb2-example-theme', ob_get_clean() );
}
add_action( 'wp_enqueue_scripts', 'cmb2_example_theme_scripts' );