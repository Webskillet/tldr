<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 */

// search box - can be placed anywhere in the template
/*
		<div id="search-container" class="search-box-wrapper hide">
			<div class="search-box">
				<?php get_search_form(); ?>
			</div>
		</div>
*/

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" xmlns:og="http://opengraphprotocol.org/schema/"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" xmlns:og="http://opengraphprotocol.org/schema/"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" xmlns:og="http://opengraphprotocol.org/schema/"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?> xmlns:og="http://opengraphprotocol.org/schema/"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, maximum-scale=1.0">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed site">

<div id="header-wrapper">
	<header id="header" class="site-header clearfix container" role="banner">
		<div class="header-inner">
			<hgroup class="site-name-slogan">
				<h1 class="site-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-slogan"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>

<?php
// search toggle for screen readers, add here if the search box is anywhere below the navigation
/*
			<div class="search-toggle">
				<a href="#search-container" class="screen-reader-text"><?php _e( 'Search', 'tldr' ); ?></a>
			</div>
*/
?>

		</div>
	</header><!-- #header -->
</div>

<div id="navigation-wrapper">
	<nav id="navigation" class="site-navigation primary-navigation clearfix container" role="navigation">
		<div class="navigation-inner">
			<h2 class="navigation-header"><?php tldr_navigation_title(); ?></h2>
			<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'tldr' ); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'main-menu', 'container_class' => 'main-menu' ) ); ?>
		</div>
	</nav>
</div>

<?php if ( is_active_sidebar( 'highlighted' ) ) : ?>
<div id="highlighted-wrapper">
	<div id="highlighted" class="highlighted widget-area clearfix container" role="complementary">
		<div class="highlighted-inner row">
			<?php dynamic_sidebar( 'highlighted' ); ?>
		</div>
	</div><!-- #highlighted -->
</div>
<?php endif; ?>

<div class="main-wrapper"><div id="main" class="clearfix container">
