<?php
/**
 * Template Name: Emergency Page
 * Template Post Type: page, revision
 *
 * The template for the home page during an emergency.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/#creating-custom-page-templates-for-global-use
 *
 * @package homesite-2017
 */

if ( have_posts() ) {
  the_post();

  get_header();
  ?>

  <main id="main" role="main">
    <h2 id="main-content" class="sr-only-element" tabindex="-1">Main Content</h2>

    <?php get_template_part( 'template-parts/content', 'emergency' ); ?>

  </main><!-- #main -->

  <?php
  get_footer();
} else {
  get_template_part( '404' );
}