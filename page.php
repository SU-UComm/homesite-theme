<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package homesite-2017
 */

if ( have_posts() ) {
  the_post();

  get_header();
  ?>

  <main id="main" role="main">
    <h2 id="main-content" class="sr-only-element" tabindex="-1">Main Content</h2>

    <?php get_template_part( 'template-parts/content', 'page' ); ?>

  </main><!-- #main -->

  <?php
  get_footer();
} else {
  get_template_part( '404' );
}
