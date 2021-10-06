<?php
/**
 * The template for displaying the front page of the site.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package homesite-2017
 */

global $home_type;
$page_template = get_page_template_slug();
if ( strpos( $page_template, 'emergency') !== FALSE ) {
  $template  = 'emergency';
  $home_type = 'emergency-home';
} else {
  $template  = 'front';
  $home_type = 'normal-home';
}
add_filter( 'body_class', function($classes){
  global $home_type;
  $classes[] = $home_type;
  return $classes;
} );

if ( have_posts() ) {
  the_post();

  get_header();
  ?>

  <main id="main" role="main">
    <h2 id="main-content" class="sr-only-element" tabindex="-1">Main Content</h2>

    <?php get_template_part( 'template-parts/content', $template ); ?>

  </main><!-- #main -->

  <?php
  get_footer();
} else {
  get_template_part( '404' );
}
