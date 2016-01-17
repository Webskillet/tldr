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

4. Content
	tldr_navigation_title - returns title for navigation
	tldr_body_classes - extends default WP body classes
	tldr_post_classes - extends default WP post classes

5. shortcodes

6. Admin
	tldr_register_options,
	tldr_theme_options,
	tldr_theme_options_page,
	tldr_validate_options

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
	'google_fonts' => '',
	'fontawesome' => 1,
	'navigation_title' => 'Navigation',
	'navigation_icon' => 'fa-bars',
	'editor_perms' => 0,
	'footer_cols' => 3,
);
$tldr_options = get_option( 'tldr_options', $tldr_options );



/**
 * 2. Setup functions
 * -----------------------------------------------------------
 */

if ( ! function_exists( 'tldr_setup' ) ) :
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
 * Register three tldr widget areas.
 *
 * @since tldr 1.0
 *
 * @return void
 */
function tldr_widgets_init() {
	global $tldr_options;

	switch ( $tldr_options['footer_cols'] ) {
		case 2:
			$footer_widget_class = 'col-sm-6';
			break;
		case 3:
			$footer_widget_class = 'col-sm-4';
			break;
		case 4:
			$footer_widget_class = 'col-sm-6 col-md-3';
			break;
	}

	// register widgets here
	// require get_template_directory() . '/inc/widgets.php';
	// register_widget( 'Webskillet14_Widget' );

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'tldr' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Content Widget Area', 'tldr' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Additional widget area that appears below the content.', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'tldr' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'tldr' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s '.$footer_widget_class.'">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'tldr_widgets_init' );


/**
 * Set default widgets
 */

/*
function tldr_set_default_widgets() {

	$widgets = get_option('sidebars_widgets');
	$widgets['sidebar-1'] = array();
	$widgets['sidebar-3'] = array(
		0 => 'widget_tldr_widgetname-1',
	);
	update_option('sidebars_widgets', $widgets);

	update_option('widget_widget_tldr_widgetname',array(
		1 => array(
			'option' => '(option value)',
		),
		'_multiwidget' => 1,
	) );
}
add_action('after_switch_theme', 'actionsite_set_default_widgets');
*/


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
add_filter( 'wp_title', 'tldr_wp_title', 10, 2 );



/**
 * Register Google fonts for tldr.
 *
 * @since tldr 1.0
 *
 * @return string
 */
function tldr_font_url() {
	global $tldr_options;
	$font_url = '';
	if ($tldr_options['google_fonts']) {
		$font_url = add_query_arg( 'family', $tldr_options['google_fonts'], "//fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since tldr 1.0
 *
 * @return void
 */
function tldr_scripts() {
	global $tldr_options;
	$css_deps = array();
	$js_deps = array( 'jquery' );

	// Add Google fonts.
	$font_url = tldr_font_url();
	if ($font_url) {
		wp_enqueue_style( 'tldr-googlefonts', $font_url, array(), null );
		$css_deps[] = 'tldr-googlefonts';
	}

	// Fontawesome
	wp_enqueue_style( 'tldr-fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css', array(), '4.2.0' );
	$css_deps[] = 'tldr-fontawesome';

	// Load our reset and bootstrap
	wp_enqueue_style( 'tldr-reset', get_template_directory_uri() . '/css/reset.css', $css_deps, '20131205' );
	$css_deps[] = 'tldr-reset';
	wp_enqueue_style( 'tldr-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', $css_deps, '20131205' );
	$css_deps[] = 'tldr-bootstrap';

	// Load our compass/sass stylesheet, where all of the actual styles happen
	wp_enqueue_style( 'tldr-style', get_template_directory_uri() . '/css/screen.css', $css_deps );

	// Finally, load our main theme stylesheet
	wp_enqueue_style( 'tldr-style', get_stylesheet_uri(), $css_deps );

	// Load the print stylesheet
	wp_enqueue_style( 'tldr-print', get_template_directory_uri() . '/css/print.css', array( 'tldr-style' ), '20131205', 'print' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'tldr-modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '20140213' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'tldr-script', get_template_directory_uri() . '/js/wsutil.js', $jsdeps, '20131209' );
}
add_action( 'wp_enqueue_scripts', 'tldr_scripts' );



/**
 * 4. Content functions
 * -----------------------------------------------------------
 */

function tldr_navigation_title() {
	global $tldr_options;
	$output = '';
	if ($tldr_options['navigation_icon'] && $tldr_options['fontawesome']) {
		$output .= '<i class="fa '.$tldr_options['navigation_icon'].'"></i> ';
	}
	$output .= translate($output ? $tldr_options['navigation_title'] : ($tldr_options['navigation_title'] ? $tldr_options['navigation_title'] : 'Navigation'), 'tldr');
	echo $output;
}

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
function tldr_body_classes( $classes ) {
	global $tldr_options;

	if ( $tldr_options['fontawesome'] ) {
		$classes[] = 'fontawesome';
	}

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

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$classes[] = 'content-widgets';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() ) {
		$classes[] = 'front';
	} else {
		$classes[] = 'not-front';
	}

	return $classes;
}
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
function tldr_post_classes( $classes ) {
	if ( ! post_password_required() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'tldr_post_classes' );

function tldr_footer_class() {
	global $tldr_options;

	if ( $tldr_options['footer_cols'] == 'flex' ) {
		// use wp_get_sidebars_widgets() to figure out number of widgets
	}
}


/**
 * 5. Shortcodes
 * -----------------------------------------------------------
 */

function tldr_html( $atts, $content ) {
	$content = preg_replace('#</?p>|<br ?/?>#','',$content);
	return $content;
}
add_shortcode('html', 'tldr_html');


/**
 * 6. Administration
 * -----------------------------------------------------------
 */

if ( is_admin() ) : // Load only if we are viewing an admin page

function tldr_register_options() {
	// Register settings and call sanitation functions
	register_setting( 'tldr_theme_options', 'tldr_options', 'tldr_validate_options' );
}
add_action( 'admin_init', 'tldr_register_options' );

function tldr_theme_options() {

	// Add theme options page to the addmin menu
	add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'tldr_theme_options_page' );
}
add_action( 'admin_menu', 'tldr_theme_options' );

// Function to generate options page
function tldr_theme_options_page() {
	global $tldr_options;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>";
	// This shows the page's name and an icon if one has been provided ?>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>

	<form method="post" action="options.php">

	<?php $settings = get_option( 'tldr_options', $tldr_options ); ?>
	
	<?php settings_fields( 'tldr_theme_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>

	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

	<tr valign="top"><th scope="row"><label for="google_fonts">Google Fonts</label></th>
	<td>
	<input id="google_fonts" name="tldr_options[google_fonts]" type="text" value="<?php  esc_attr_e($settings['google_fonts']); ?>" />
	</td>
	</tr>

	<tr valign="top"><th scope="row">Fontawesome</th>
	<td>
	<input type="checkbox" id="fontawesome" name="tldr_options[fontawesome]" value="1" <?php checked( true, $settings['fontawesome'] ); ?> />
	<label for="fontawesome">Load Fontawesome</label>
	</td>
	</tr>

	<tr valign="top"><th scope="row">Navigation</th>
	<td>
	<label for="navigation_title" style="width: 8em; display: inline-block;">Navigation Title</label>
	<input id="navigation_title" name="tldr_options[navigation_title]" type="text" value="<?php  esc_attr_e($settings['navigation_title']); ?>" /><br />
	<label for="navigation_icon" style="width: 8em; display: inline-block;">Navigation Icon</label>
	<input id="navigation_icon" name="tldr_options[navigation_icon]" type="text" value="<?php  esc_attr_e($settings['navigation_icon']); ?>" /><br />
	<small><em>Note: Navigation Icon should be a <a href="http://fortawesome.github.io/Font-Awesome/icons/">Fontawesome icon class</a>.  It will only display if Fontawesome is loaded</em>
	</td>
	</tr>

	<tr valign="top"><th scope="row">Footer Widgets</th>
	<td>
	<label for="footer_cols">Number of Columns</label>
	<select id="footer_cols" name="tldr_options[footer_cols]">
		<option value="2" <?php selected( $settings['footer_cols'], 2 ); ?>>2</option>
		<option value="3" <?php selected( $settings['footer_cols'], 3 ); ?>>3</option>
		<option value="4" <?php selected( $settings['footer_cols'], 4 ); ?>>4</option>
		<!--<option value="flex" <?php selected( $settings['footer_cols'], 'flex' ); ?>>flex</option>-->
	</select><!--<br />
	<small><em>Flex will display 2-4 columns, depending on how many widgets are added to the footer area</em>-->
	</td>
	</tr>

	<tr valign="top"><th scope="row">Editor Permissions</th>
	<td>
	<input type="checkbox" id="editor_perms" name="tldr_options[editor_perms]" value="1" <?php checked( true, $settings['editor_perms'] ); ?> />
	<label for="editor_perms">Give users with Editor role access to theme options (widgets, menus, etc.)</label>
	</td>
	</tr>

	</table>

	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

	</form>

	</div>

	<?php
}

function tldr_validate_options( $input ) {
	global $tldr_options;

	$settings = get_option( 'tldr_options', $tldr_options );
	
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

function tldr_add_editor_perms() {
	global $tldr_options;
	$role = get_role( 'editor' );
	if ($tldr_options['editor_perms']) {
		$role->add_cap( 'edit_theme_options' );
	} else {
		$role->remove_cap( 'edit_theme_options' );
	}
}
add_action( 'admin_init', 'tldr_add_editor_perms' );

endif;  // EndIf is_admin()
