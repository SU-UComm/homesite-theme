<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package homesite-2017
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <a id="skiplinks" href="#main"><?php esc_html_e( 'Skip to content', 'homesite17' ); ?></a>
	<header role="banner">
    <div class="su-brand" rel="home"><span class="stanford">Stanford</span><span class="stanford-university">Stanford University</span></div>
    <section id="brand-bar">
      <?php wp_nav_menu( [
          'theme_location' => 'gateway'
        , 'container'      => 'nav'
        , 'container_id'   => 'gateway'
      ] ); ?>
    </section>
    <nav id="site-navigation" role="navigation">
      <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'homesite17' ); ?></button>
      <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
    </nav>
    <?php hs_render_panels( 'header' ); ?>
	</header>
