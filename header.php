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
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!--
    _____ _               __              _
   / ____| |             / _|            | |
  | (___ | |_ __ _ _ __ | |_ ___  _ __ __| |
   \___ \| __/ _` | '_ \|  _/ _ \| '__/ _` |
   ____) | || (_| | | | | || (_) | | | (_| |
  |_____/ \__\__,_|_| |_|_| \___/|_|  \__,_|

  -->

  <?php wp_head(); ?>

  <link rel="apple-touch-icon" sizes="57x57" href="https://www-media.stanford.edu/assets/favicon/apple-touch-icon-57x57.png" />
  <link rel="apple-touch-icon" sizes="60x60" href="https://www-media.stanford.edu/assets/favicon/apple-touch-icon-60x60.png" />
  <link rel="apple-touch-icon" sizes="72x72" href="https://www-media.stanford.edu/assets/favicon/apple-touch-icon-72x72.png" />
  <link rel="apple-touch-icon" sizes="76x76" href="https://www-media.stanford.edu/assets/favicon/apple-touch-icon-76x76.png" />
  <link rel="apple-touch-icon" sizes="114x114" href="https://www-media.stanford.edu/assets/favicon/apple-touch-icon-114x114.png" />
  <link rel="apple-touch-icon" sizes="120x120" href="https://www-media.stanford.edu/assets/favicon/apple-touch-icon-120x120.png" />
  <link rel="apple-touch-icon" sizes="144x144" href="https://www-media.stanford.edu/assets/favicon/apple-touch-icon-144x144.png" />
  <link rel="apple-touch-icon" sizes="152x152" href="https://www-media.stanford.edu/assets/favicon/apple-touch-icon-152x152.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="https://www-media.stanford.edu/assets/favicon/apple-touch-icon-180x180.png" />

  <link rel="icon" type="image/png" href="https://www-media.stanford.edu/assets/favicon/favicon-196x196.png" sizes="196x196" />
  <link rel="icon" type="image/png" href="https://www-media.stanford.edu/assets/favicon/favicon-192x192.png" sizes="192x192" />
  <link rel="icon" type="image/png" href="https://www-media.stanford.edu/assets/favicon/favicon-128.png" sizes="128x128" />
  <link rel="icon" type="image/png" href="https://www-media.stanford.edu/assets/favicon/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/png" href="https://www-media.stanford.edu/assets/favicon/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="https://www-media.stanford.edu/assets/favicon/favicon-16x16.png" sizes="16x16" />

  <link rel="mask-icon" href="https://www-media.stanford.edu/assets/favicon/safari-pinned-tab.svg" color="#ffffff">
  <meta name="application-name" content="Stanford University"/>
  <meta name="msapplication-TileColor" content="#FFFFFF" />
  <meta name="msapplication-TileImage" content="https://www-media.stanford.edu/assets/favicon/mstile-144x144.png" />
  <meta name="msapplication-square70x70logo" content="https://www-media.stanford.edu/assets/favicon/mstile-70x70.png" />
  <meta name="msapplication-square150x150logo" content="https://www-media.stanford.edu/assets/favicon/mstile-150x150.png" />
  <meta name="msapplication-square310x310logo" content="https://www-media.stanford.edu/assets/favicon/mstile-310x310.png" />

  <meta name="facebook-domain-verification" content="a91q4n8v45r4nm4mtheppcx6yaf3sl" />
</head>

<body <?php body_class(); ?>>
  <header role="banner">
    <a id="skiplinks" href="#main-content" data-ga-category="Skip links" data-ga-action="header" data-ga-label="Skip to content"><?php esc_html_e( 'Skip to content', 'homesite17' ); ?></a>
    <section id="brand-bar" data-ga-category="Brand bar" data-ga-action="Gateway nav">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="su-brand" rel="home" id="header--wordmark" data-ga-action="Wordmark">Stanford University</a>
      <?php wp_nav_menu( [
          'theme_location'       => 'gateway'
        , 'container'            => 'nav'
        , 'container_id'         => 'gateway'
        , 'container_aria_label' => 'Gateway navigation'
      ] ); ?>
      <button id="search-toggle" aria-controls="site-search" aria-expanded="false" data-ga-action="Search toggle"><?php esc_html_e( 'Search', 'homesite17' ); ?></button>
      <button id="menu-toggle" aria-controls="primary-menu" aria-expanded="false" data-ga-action="Menu toggle"><?php esc_html_e( 'Menu', 'homesite17' ); ?></button>
    </section>
    <div id="menu-overlay" aria-hidden="true" role="presentation"></div>
    <nav id="site-navigation" role="navigation" aria-label="Primary site navigation" data-ga-category="Top nav">
      <?php wp_nav_menu( [
          'theme_location'  => 'primary'
        , 'menu_id'         => 'primary-menu'
        , 'container_class' => 'menu-primary-nav-container'
      ] ); ?>
    </nav>
    <?php hs_render_alerts(); ?>
    <?php get_search_form(); ?>
    <?php hs_render_panels( 'header' ); ?>
  </header>