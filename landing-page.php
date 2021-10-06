<?php
/**
 * Template Name: Landing Page
 * Template Post Type: page, revision
 *
 * The template for displaying landing pages.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/#creating-custom-page-templates-for-global-use
 *
 * @package homesite-2017
 */

if ( have_posts() ) {
  the_post();

  get_header();

  $content = trim( get_the_content() );
  ?>

  <main id="main" role="main">
    <h2 id="main-content" class="sr-only-element" tabindex="-1">Main Content</h2>
    <header>
      <?php the_title( "<h1>", "</h1>\n" ); ?>

      <?php if ( !empty( $content ) ) { ?>
      <section>
        <?php the_content(); ?>
      </section><!-- .entry-content -->
      <?php } ?>

    </header><!-- .entry-header -->

    <?php hs_render_panels( 'main' ); ?>

  </main><!-- #main -->

  <?php
  get_footer();

} else {
  get_template_part( '404' );
}
