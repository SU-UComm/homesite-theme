<?php
/**
 * Template Name: Sidebar Page
 * Template Post Type: page, revision
 *
 * The template for displaying a page with a sidebar, e.g. the Faculty & Staff Gateway page.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/#creating-custom-page-templates-for-global-use
 *
 * @package homesite-2017
 */

if ( have_posts() ) {
  the_post();

  get_header();

  $content = trim( get_the_content() );

  global $hs_post_panels;
  foreach ( $hs_post_panels[ 'main' ] as $index => $panel ) {
    $panel_vars  = $panel->get_template_vars();
    $page_region = ( isset( $panel_vars[ 'page_region' ] ) && !empty( $panel_vars[ 'page_region' ] ) ) ? $panel_vars[ 'page_region' ] : 'main';
    if ( $page_region !== 'main' ) {
      if ( !isset( $hs_post_panels[ $page_region ] ) ) $hs_post_panels[ $page_region ] = [];
      $hs_post_panels[ $page_region ][] = $panel;
      unset( $hs_post_panels[ 'main' ][ $index ] );
    }
  }
  ?>

  <main id="main" role="main">
    <h2 id="main-content" class="sr-only-element" tabindex="-1">Main Content</h2>
    <header>
      <?php the_title( "<h1 class=\"sr-only-element\">", "</h1>\n" ); ?>

      <?php hs_render_panels( 'main-header' ); ?>
    </header><!-- .entry-header -->

    <section id="main-content-body">
      <section>
        <?php the_content(); ?>
        <?php hs_render_panels( 'main' ); ?>
      </section><!-- .entry-content -->

      <aside>
        <?php hs_render_panels( 'sidebar' ); ?>
      </aside>
    </section>

  </main><!-- #main -->

  <?php
  get_footer();

} else {
  get_template_part( '404' );
}
