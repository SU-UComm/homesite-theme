<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package homesite-2017
 */

hs_sort_panels_by_region();

get_header(); ?>

  <main id="main" role="main" tabindex="-1">

  <?php
  while ( have_posts() ) : the_post();

    get_template_part( 'template-parts/content', get_post_format() );

    the_post_navigation();

  endwhile; // End of the loop.
  ?>

  </main><!-- #main -->

<?php
get_sidebar();
get_footer();
