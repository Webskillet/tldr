<?php
/**
 * tldr functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/** table of contents

1. Settings & variables:
	content width
	version compare
	options values

2. Setup:
	tldr_setup - Set up theme defaults and registers support for various WordPress features.
	tldr_widgets_init - Initialize widgets

3. Meta
	tldr_wp_title - more specific title element
	tldr_font_url - Google fonts
	tldr_scripts - load scripts and css dynamically
	tldr_custom_css - loads custom css from theme options
	tldr_custom_js - loads custom javascript from theme options

4. Content
	tldr_navigation_title - returns title for navigation
	tldr_body_classes - extends default WP body classes
	tldr_post_classes - extends default WP post classes

5. shortcodes
	tldr_html - shortcode for including raw HTML (to evade filter)

6. Admin
	tldr_register_options,
	tldr_theme_options,
	tldr_theme_options_page,
	tldr_theme_options_help,
	tldr_validate_options - create options page
	tldr_add_editor_perms - give users with "editor" role access to theme options (menus, widgets, etc.)
	

*/


/**
 * 1. Setting variables
 * -----------------------------------------------------------
 */

/**
 * Set up the content width value based on the theme's design.
 *
 * @see tldr_content_width()
 *
 * @since tldr 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 613;
}

/**
 * tldr only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

/**
 * tldr options values
 */
global $tldr_options;
$tldr_options = array(
	'logo_url' => '',
	'navigation_style' => 'default',
	'navigation_title' => 'Navigation',
	'navigation_icon' => 'fa-bars',
	'highlighted_cols' => 1,
	'prefooter1_cols' => 3,
	'prefooter2_cols' => 2,
	'footer_cols' => 3,
	'google_fonts' => '',
	'custom_css' => '',
	'validateForms' => 1,
	'fixFooter' => 0,
	'shortenLinks' => 1,
	'externalLinks' => 1,
	'externalLinksExceptions' => '',
	'sectionNavigationSelector' => '.section-navigation',
	'sectionNavigationPadding' => 20,
	'custom_js' => '',
	'editor_perms' => 0,
);
$tldr_options = get_option( 'tldr_options', $tldr_options );



/**
 * 2. Setup functions
 * -----------------------------------------------------------
 */


/**
 * tldr setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since tldr 1.0
 */
if ( ! function_exists( 'tldr_setup' ) ) :
function tldr_setup() {

	/*
	 * Make tldr available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on tldr, use a find and
	 * replace to change 'tldr' to the name of your theme in all
	 * template files.
	 */

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', tldr_font_url() ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 160, 160, true );
	add_image_size( 'tldr-full-width', 640, 360, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'tldr' ),
		'secondary' => __( 'Secondary menu in left sidebar', 'tldr' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
/*
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );
*/

}
endif; // tldr_setup
add_action( 'after_setup_theme', 'tldr_setup' );

/**
 * Register tldr widget areas.
 *
 * @since tldr 1.0
 *
 * @return void
 */
if ( ! function_exists( 'tldr_widgets_init' ) ) :
function tldr_widgets_init() {
	global $tldr_options;

	foreach (array('highlighted','prefooter1','prefooter2','footer') as $sidebar) {
		switch ( $tldr_options[$sidebar.'_cols'] ) {
			case 1:
				$widget_class[$sidebar] = 'col-sm-12';
				break;
			case 2:
				$widget_class[$sidebar] = 'col-sm-6';
				break;
			case 3:
				$widget_class[$sidebar] = 'col-sm-4';
				break;
			case 4:
				$widget_class[$sidebar] = 'col-sm-6 col-md-3';
				break;
/*
			case 'flex':
				// use wp_get_sidebars_widgets() to figure out number of widgets
				// https://codex.wordpress.org/Function_Reference/wp_get_sidebars_widgets
				break;
*/


		}
	}

	// register widgets here
	// require get_template_directory() . '/inc/widgets.php';
	// register_widget( 'Webskillet14_Widget' );

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'tldr' ),
		'id'            => 'sidebar',
		'description'   => __( 'Main sidebar', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Highlighted', 'tldr' ),
		'id'            => 'highlighted',
		'description'   => __( 'Additional widget area that appears above the content.', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s '.$widget_class['highlighted'].'">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Prefooter 1', 'tldr' ),
		'id'            => 'prefooter1',
		'description'   => __( 'First of two widgets areas that appear below the content, above the footer.', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s '.$widget_class['prefooter1'].'">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Prefooter 2', 'tldr' ),
		'id'            => 'prefooter2',
		'description'   => __( 'Second of two widgets areas that appear below the content, above the footer.', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s '.$widget_class['prefooter2'].'">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Utility Widget Area', 'tldr' ),
		'id'            => 'utility',
		'description'   => __( 'Appears just above the footer on mobile, on iPads and larger widgets can be placed using absolute positions anywhere on the site (requires custom css in theme). Generally used to place secondary or utility menus in upper right-hand corner', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'tldr' ),
		'id'            => 'footer',
		'description'   => __( 'Appears in the footer section of the site.', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s '.$widget_class['footer'].'">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Modals', 'tldr' ),
		'id'            => 'modals',
		'description'   => __( 'Any widget placed in this area can be opened as a modal by linking to its id attribute', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Reveal Left', 'tldr' ),
		'id'            => 'reveal-left',
		'description'   => __( 'Any widget placed in this area can be opened as a left-side reveal by linking to its id attribute', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Reveal Right', 'tldr' ),
		'id'            => 'reveal-right',
		'description'   => __( 'Any widget placed in this area can be opened as a right-side reveal by linking to its id attribute', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
endif;
add_action( 'widgets_init', 'tldr_widgets_init' );



/**
 * 3. Meta functions
 * -----------------------------------------------------------
 */

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since tldr 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
if ( ! function_exists( 'tldr_wp_title' ) ) :
function tldr_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'tldr' ), max( $paged, $page ) );
	}

	return $title;
}
endif;
add_filter( 'wp_title', 'tldr_wp_title', 10, 2 );



/**
 * Register Google fonts for tldr.
 *
 * @since tldr 1.0
 *
 * @return string
 */
if ( ! function_exists( 'tldr_font_url' ) ) :
function tldr_font_url() {
	global $tldr_options;
	$font_url = '';
	if ($tldr_options['google_fonts']) {
		$font_url = add_query_arg( 'family', $tldr_options['google_fonts'], "//fonts.googleapis.com/css" );
	}

	return $font_url;
}
endif;

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since tldr 1.0
 *
 * @return void
 */
if ( ! function_exists( 'tldr_scripts' ) ) :
function tldr_scripts() {
	global $tldr_options;
	$css_deps = array();

	/**
	 * css
	 */

	// Add Google fonts.
	$font_url = tldr_font_url();
	if ($font_url) {
		wp_enqueue_style( 'tldr-googlefonts', $font_url, array(), null );
		$css_deps[] = 'tldr-googlefonts';
	}

	// Fontawesome
	wp_enqueue_style( 'tldr-fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '4.5.0' );
	$css_deps[] = 'tldr-fontawesome';

	// Load our reset and bootstrap
	wp_enqueue_style( 'tldr-reset', get_template_directory_uri() . '/css/reset.css', $css_deps, '20131205' );
	$css_deps[] = 'tldr-reset';
	wp_enqueue_style( 'tldr-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', $css_deps, '20131205' );
	$css_deps[] = 'tldr-bootstrap';

	// Load our compass/sass stylesheet, where all of the actual styles happen
	wp_enqueue_style( 'tldr-screen', get_template_directory_uri() . '/css/screen.css', $css_deps );

	// we don't load our main theme stylesheet, because it does not include any actual styling
	// wp_enqueue_style( 'tldr-style', get_stylesheet_uri(), $css_deps );

	// Load the print stylesheet
	wp_enqueue_style( 'tldr-print', get_template_directory_uri() . '/css/print.css', array( 'tldr-screen' ), '20131205', 'print' );

	/**
	 * javascript
	 */

	// prepare options to pass to javascript
	$options_to_pass = array(
		'validateForms',
		'fixFooter',
		'shortenLinks',
		'externalLinks',
		'externalLinksExceptions',
		'sectionNavigationSelector',
		'sectionNavigationPadding',
	);
	foreach ($options_to_pass as $option_key) {
		$tldr_options_js[$option_key] = isset($tldr_options[$option_key]) ? $tldr_options[$option_key] : '';
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'tldr-modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '20140213' );
	wp_enqueue_script( 'tldr-fastclick', get_template_directory_uri() . '/js/fastclick.min.js', array(), '20160116' );
	wp_enqueue_script( 'tldr-hammer', get_template_directory_uri() . '/js/hammer.min.js', array(), '20160116' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'tldr-jquery-validate', get_template_directory_uri() . '/js/jquery.validate.js', array( 'jquery' ), '20160116' );
	wp_enqueue_script( 'tldr-wsutil', get_template_directory_uri() . '/js/wsutil.js', array('tldr-modernizr', 'tldr-fastclick', 'tldr-hammer', 'jquery', 'tldr-jquery-validate'), '20160414' );
	wp_localize_script( 'tldr-wsutil', 'TLDRoptions', $tldr_options_js);
}
endif;
add_action( 'wp_enqueue_scripts', 'tldr_scripts' );

/**
 * Add custom css and js from theme options
 *
 * @since tldr 1.0
 *
 * @return void
 */
if ( ! function_exists( 'tldr_custom_css' ) ) :
function tldr_custom_css() {
	global $tldr_options;
	$custom_css = trim($tldr_options['custom_css']);
	if ($custom_css) { echo "<style>\n".$custom_css."\n</style>"; }
}
endif;
add_action( 'wp_head', 'tldr_custom_css', 8 );

if ( ! function_exists( 'tldr_custom_js' ) ) :
function tldr_custom_js() {
	global $tldr_options;
	$custom_js = trim($tldr_options['custom_js']);
	if ($custom_js) { echo "<script>\n".$custom_js."\n</script>"; }
}
endif;
add_action( 'wp_head', 'tldr_custom_js', 9 );



/**
 * 4. Content functions
 * -----------------------------------------------------------
 */

if ( ! function_exists( 'tldr_get_logo' ) ) :
function tldr_get_logo() {
	global $tldr_options;
	$output = '';
	if ($tldr_options['logo_url']) {
		$output .= '<img src="'.$tldr_options['logo_url'].'" />';
	}
	return $output;
}
endif;

if ( ! function_exists( 'tldr_navigation_title' ) ) :
function tldr_navigation_title() {
	global $tldr_options;
	$output = '';
	if ($tldr_options['navigation_icon']) {
		$output .= '<i class="fa '.$tldr_options['navigation_icon'].'"></i> ';
	}
	$output .= translate($output ? $tldr_options['navigation_title'] : ($tldr_options['navigation_title'] ? $tldr_options['navigation_title'] : 'Navigation'), 'tldr');
	echo $output;
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 4. Full-width content layout.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since tldr 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
if ( ! function_exists( 'tldr_body_classes' ) ) :
function tldr_body_classes( $classes ) {
	global $tldr_options;

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} else {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( ( ! is_active_sidebar( 'sidebar-1' ) )
		|| is_attachment() ) {
		$classes[] = 'full-width';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() ) {
		$classes[] = 'front';
	} else {
		$classes[] = 'not-front';
	}

	$classes[] = 'mobile-style-'.$tldr_options['navigation_style'];

	return $classes;
}
endif;
add_filter( 'body_class', 'tldr_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since tldr 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
if ( ! function_exists( 'tldr_post_classes' ) ) :
function tldr_post_classes( $classes ) {
	if ( ! post_password_required() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
endif;
add_filter( 'post_class', 'tldr_post_classes' );


/**
 * 5. Shortcodes
 * -----------------------------------------------------------
 */

if ( ! function_exists( 'tldr_html' ) ) :
function tldr_html( $atts, $content ) {
	$content = preg_replace('#</?p>|<br ?/?>#','',$content);
	return $content;
}
endif;
add_shortcode('html', 'tldr_html');


/**
 * 6. Administration
 * -----------------------------------------------------------
 */

if ( is_admin() ) : // Load only if we are viewing an admin page

if ( ! function_exists('tldr_enqueue_admin_scripts') ) :
function tldr_enqueue_admin_scripts(){
	wp_register_script( 'tldr-admin-js', get_template_directory_uri() . '/js/admin.js', array ( 'jquery', 'media-upload', 'thickbox' ) );
	wp_register_style( 'tldr-admin-css', get_template_directory_uri() . '/css/admin.css', array ( 'dashicons', 'wp-admin', 'buttons' ) );
	if ( get_current_screen() -> id == 'appearance_page_theme_options' ) {

		wp_enqueue_script('jquery');

		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');

		wp_enqueue_script('media-upload');
		wp_enqueue_script('tldr-admin-js');

		wp_enqueue_style('tldr-admin-css');
	}
}
endif;
add_action( 'admin_enqueue_scripts', 'tldr_enqueue_admin_scripts' );

if ( ! function_exists( 'tldr_register_options' ) ) :
function tldr_register_options() {
	global $pagenow;

	// Register settings and call sanitation functions
	register_setting( 'tldr_theme_options', 'tldr_options', 'tldr_validate_options' );

	// set up text filter to change button on media uploader when we're choosing a logo
	if ( $pagenow == 'media-upload.php' || $pagenow == 'async-upload.php' ) {
		add_filter( 'gettext', 'tldr_replace_thickbox_text', 1, 3 );
	}
}
endif;
add_action( 'admin_init', 'tldr_register_options' );

if ( ! function_exists( 'tldr_replace_thickbox_text' ) ) :
function tldr_replace_thickbox_text($translated_text, $text, $domain) {
	if ($text == 'Insert into Post') {
		$referer = strpos( wp_get_referer(), 'tldr-settings' );
		if ($referer !== false) {
			return __('Select as logo', 'tldr' );
		}
	}
	return $translated_text;
}
endif;

if ( ! function_exists( 'tldr_theme_options' ) ) :
function tldr_theme_options() {

	// Add theme options page to the admin menu
	$theme_page_hook = add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'tldr_theme_options_page' );
	add_action( 'load-' . $theme_page_hook, 'tldr_theme_options_help' );
}
endif;
add_action( 'admin_menu', 'tldr_theme_options' );

// Function to generate options page
if ( ! function_exists( 'tldr_theme_options_page' ) ) :
function tldr_theme_options_page() {
	global $tldr_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	<?php echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>";
	// This shows the page's name and an icon if one has been provided ?>

	<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
	<div class="updated notice is-dismissible"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>

	<form method="post" action="options.php">

	<?php $settings = get_option( 'tldr_options', $tldr_options ); ?>
	
	<?php settings_fields( 'tldr_theme_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>

	<table class="form-table"><tbody>

	<tr valign="top"><th scope="row"><label for="logo_url">Logo</label></th>
	<td>
	<div id="logo_url_preview" style="width: 100px; float: left; margin-right: 20px;<?php echo $settings['logo_url'] ? '' : ' display: none;'; ?>">
		<?php if ($settings['logo_url']) : ?><img src="<?php echo esc_url($settings['logo_url']); ?>" style="max-width: 100%;" /><?php endif; ?>
	</div>
	<input type="text" id="logo_url" name="tldr_options[logo_url]" value="<?php echo esc_url($settings['logo_url']); ?>" />
	<div style="margin-bottom: 5px;"><button class="button" id="logo_url_upload_button" style="display: none;"><span class="dashicons dashicons-upload"></span> Upload or choose <?php echo $settings['logo_url'] ? 'another ' : ''; ?>logo</button></div>
	<div><button class="button" id="logo_url_delete_button"<?php echo $settings['logo_url'] ? '' : ' style="display: none;"'; ?>><span class="dashicons dashicons-no"></span> Remove logo</button></div>
	</td>
	</tr>

	<tr valign="top"><th scope="row">Navigation</th>
	<td>
	<label for="navigation_style" style="width: 8em; display: inline-block;">Navigation Style</label>
	<select id="navigation_style" name="tldr_options[navigation_style]">
		<option value="default" <?php selected( $settings['navigation_style'], 'default' ); ?>>Default</option>
		<option value="basic" <?php selected( $settings['navigation_style'], 'basic' ); ?>>Basic</option>
	</select>
	<span class="dashicons dashicons-editor-help" title="More information available in the help dropdown"></span><br />

	<label for="navigation_title" style="width: 8em; display: inline-block;">Navigation Title</label>
	<input id="navigation_title" name="tldr_options[navigation_title]" type="text" value="<?php  esc_attr_e($settings['navigation_title']); ?>" /><br />
	<label for="navigation_icon" style="width: 8em; display: inline-block;">Navigation Icon</label>
	<input id="navigation_icon" name="tldr_options[navigation_icon]" type="text" value="<?php  esc_attr_e($settings['navigation_icon']); ?>" /><br />
	<small><em>Note: Navigation Icon should be a <a href="http://fortawesome.github.io/Font-Awesome/icons/">Fontawesome icon class</a></em>
	</td>
	</tr>

	<tr valign="top"><th scope="row">Number of Columns in Widget Areas</th>
	<td>

	<table><tbody><tr>
	<td width="25%" style="padding-left: 0;"><label for="highlighted_cols">Highlighted</label>
	<select id="highlighted_cols" name="tldr_options[highlighted_cols]">
		<option value="1" <?php selected( $settings['highlighted_cols'], 1 ); ?>>1</option>
		<option value="2" <?php selected( $settings['highlighted_cols'], 2 ); ?>>2</option>
		<option value="3" <?php selected( $settings['highlighted_cols'], 3 ); ?>>3</option>
		<option value="4" <?php selected( $settings['highlighted_cols'], 4 ); ?>>4</option>
		<!--<option value="flex" <?php selected( $settings['highlighted_cols'], 'flex' ); ?>>flex</option>-->
	</select><!--<br />
	<small><em>Flex will display 1-4 columns, depending on how many widgets are added to the area</em>--></td>

	<td width="25%"><label for="prefooter1_cols">Prefooter 1</label>
	<select id="prefooter1_cols" name="tldr_options[prefooter1_cols]">
		<option value="1" <?php selected( $settings['prefooter1_cols'], 1 ); ?>>1</option>
		<option value="2" <?php selected( $settings['prefooter1_cols'], 2 ); ?>>2</option>
		<option value="3" <?php selected( $settings['prefooter1_cols'], 3 ); ?>>3</option>
		<option value="4" <?php selected( $settings['prefooter1_cols'], 4 ); ?>>4</option>
		<!--<option value="flex" <?php selected( $settings['prefooter1_cols'], 'flex' ); ?>>flex</option>-->
	</select><!--<br />
	<small><em>Flex will display 1-4 columns, depending on how many widgets are added to the area</em>--></td>

	<td width="25%"><label for="prefooter2_cols">Prefooter 2</label>
	<select id="prefooter2_cols" name="tldr_options[prefooter2_cols]">
		<option value="1" <?php selected( $settings['prefooter2_cols'], 1 ); ?>>1</option>
		<option value="2" <?php selected( $settings['prefooter2_cols'], 2 ); ?>>2</option>
		<option value="3" <?php selected( $settings['prefooter2_cols'], 3 ); ?>>3</option>
		<option value="4" <?php selected( $settings['prefooter2_cols'], 4 ); ?>>4</option>
		<!--<option value="flex" <?php selected( $settings['prefooter2_cols'], 'flex' ); ?>>flex</option>-->
	</select><!--<br />
	<small><em>Flex will display 1-4 columns, depending on how many widgets are added to the area</em>--></td>

	<td width="25%"><label for="footer_cols">Footer</label>
	<select id="footer_cols" name="tldr_options[footer_cols]">
		<option value="1" <?php selected( $settings['footer_cols'], 1 ); ?>>1</option>
		<option value="2" <?php selected( $settings['footer_cols'], 2 ); ?>>2</option>
		<option value="3" <?php selected( $settings['footer_cols'], 3 ); ?>>3</option>
		<option value="4" <?php selected( $settings['footer_cols'], 4 ); ?>>4</option>
		<!--<option value="flex" <?php selected( $settings['footer_cols'], 'flex' ); ?>>flex</option>-->
	</select><!--<br />
	<small><em>Flex will display 1-4 columns, depending on how many widgets are added to the area</em>--></td>
	</tr></tbody></table>

	</td>
	</tr>

	<tr valign="top">
		<th scope="row"><label for="google_fonts">Google Fonts</label></th>
		<td>
			<input id="google_fonts" name="tldr_options[google_fonts]" type="text" value="<?php  esc_attr_e($settings['google_fonts']); ?>" />
			<span class="dashicons dashicons-editor-help" title="More information available in the help dropdown"></span>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row"><label for="custom_css">Custom CSS</label></th>
		<td><textarea id="custom_css" name="tldr_options[custom_css]"><?php esc_attr_e($settings['custom_css']); ?></textarea></td>
	</tr>

	<tr valign="top"><th scope="row">Javascript Options</th>

	<td>
	<p><input type="checkbox" id="validateForms" name="tldr_options[validateForms]" value="1" <?php checked( true, $settings['validateForms'] ); ?> />
	<label for="validateForms">Validate all forms by default</label><br />
	<input type="checkbox" id="fixFooter" name="tldr_options[fixFooter]" value="1" <?php checked( true, $settings['fixFooter'] ); ?> />
	<label for="fixFooter">Fix footer to the bottom of the window if content is less than full height</label><br />
	<input type="checkbox" id="shortenLinks" name="tldr_options[shortenLinks]" value="1" <?php checked( true, $settings['shortenLinks'] ); ?> />
	<label for="shortenLinks">Shorten links to fit within their containers</label><br />
	<input type="checkbox" id="externalLinks" name="tldr_options[externalLinks]" value="1" <?php checked( true, $settings['externalLinks'] ); ?> />
	<label for="externalLinks">Open external links in a new window</label></p>
	<p><label for="externalLinksExceptions">jQuery selector for external links that should <strong>not</strong> be opened in a new window:</label><br />
	<input type="text" id="externalLinksExceptions" name="tldr_options[externalLinksExceptions]" value="<?php esc_attr_e($settings['externalLinksExceptions']); ?>" /></p>
	<p><label for="sectionNavigationSelector">jQuery selector for anchor links that should trigger scrolling in-page navigation:</label><br />
	<input type="text" id="sectionNavigationSelector" name="tldr_options[sectionNavigationSelector]" value="<?php esc_attr_e($settings['sectionNavigationSelector']); ?>" /></p>
	<p><label for="sectionNavigationPadding">Top-of-page padding for scrolling in-page navigation (in pixels):</label><br />
	<input type="text" id="sectionNavigationPadding" name="tldr_options[sectionNavigationPadding]" value="<?php esc_attr_e($settings['sectionNavigationPadding']); ?>" /></p>
	</td>
	</tr>

	<tr valign="top">
		<th scope="row"><label for="custom_js">Custom Javascript</label></th>
		<td><textarea id="custom_js" name="tldr_options[custom_js]"><?php esc_attr_e($settings['custom_js']); ?></textarea></td>
	</tr>

	<tr valign="top"><th scope="row">Editor Permissions</th>
	<td>
	<input type="checkbox" id="editor_perms" name="tldr_options[editor_perms]" value="1" <?php checked( true, $settings['editor_perms'] ); ?> />
	<label for="editor_perms">Give users with Editor role access to theme options (widgets, menus, etc.)</label>
	</td>
	</tr>

	</table>

	<p class="submit"><input type="submit" id="options-form-submit" class="button-primary" value="Save Options" /></p>

	</form>

	</div>

	<?php
}
endif;

if ( ! function_exists( 'tldr_theme_options_help' ) ) :
function tldr_theme_options_help() {
	$screen = get_current_screen();
	
	$screen->add_help_tab( array(
		'id'       => 'tldr-theme-navigation-style',
		'title'    => __( 'Navigation Style' ),
		'content'  => '
<p><strong>Default:</strong> On devices smaller than an iPad (768 pixels), clicking on navigation header slides menu in from the left side, with sub-menus opening downward</p>
<p><strong>Basic:</strong> On devices smaller than an iPad (768 pixels), clicking on navigation header opens menu directly below the header, with sub-menus opening downward</p>
		',
	));

	$screen->add_help_tab( array(
		'id'       => 'tldr-theme-google-fonts',
		'title'    => __( 'Google Fonts' ),
		'content'  => '
<p>Whatever text is entered for this option will be appended to <strong>//fonts.googleapis.com/css?family=</strong> in a <link> element in the head &mdash; so if, for example, Google gives you this code to add to your website:</p>
<code>&lt;link href=\'https://fonts.googleapis.com/css?family=Roboto:400,500italic\' rel=\'stylesheet\' type=\'text/css\'&gt;</code>
<p>enter <strong>Roboto:400,500italic</strong> as the Google Fonts option.</p>
		',
	));

}
endif;

if ( ! function_exists( 'tldr_validate_options' ) ) :
function tldr_validate_options( $input ) {
	global $tldr_options;

	$settings = get_option( 'tldr_options', $tldr_options );

	$input['logo_url'] = esc_url( $input['logo_url'] );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	$input['google_fonts'] = wp_filter_nohtml_kses( $input['google_fonts'] );
	$input['navigation_title'] = wp_filter_nohtml_kses( $input['navigation_title'] );
	$input['navigation_icon'] = wp_filter_nohtml_kses( $input['navigation_icon'] );
	
	// If the checkbox has not been checked, we void it
	if ( ! isset( $input['fontawesome'] ) )
		$input['fontawesome'] = null;
	// We verify if the input is a boolean value
	$input['fontawesome'] = ( $input['fontawesome'] == 1 ? 1 : 0 );
	
	// If the checkbox has not been checked, we void it
	if ( ! isset( $input['editor_perms'] ) )
		$input['editor_perms'] = null;
	// We verify if the input is a boolean value
	$input['editor_perms'] = ( $input['editor_perms'] == 1 ? 1 : 0 );
	
	return $input;
}
endif;

if ( ! function_exists( 'tldr_add_editor_perms' ) ) :
function tldr_add_editor_perms() {
	global $tldr_options;
	$role = get_role( 'editor' );
	if ($tldr_options['editor_perms']) {
		$role->add_cap( 'edit_theme_options' );
	} else {
		$role->remove_cap( 'edit_theme_options' );
	}
}
endif;
add_action( 'admin_init', 'tldr_add_editor_perms' );

endif;  // EndIf is_admin()
