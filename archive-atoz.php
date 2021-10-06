<?php
/**
 * The template for displaying the a-z list of all websites.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package homesite-2017
 */

$filters = hs_get_filters(); // get alphabetic filters

get_header();
?>

  <main id="main" role="main">
  <h2 id="main-content" class="sr-only-element" tabindex="-1">Main Content</h2>

<?php
if ( have_posts() ) {
?>

    <header>
      <h1>Index of Stanford websites</h1>
    </header>

    <section class="entry-content">
      <?php hs_maybe_emit_filters( $filters ); ?>
      <section id="list" data-ga-category="A-Z list">
        <h2 class="sr-only-element" tabindex="-1">List of websites</h2>

<?php
  $last_alpha = '';
  while ( have_posts() ) {
    the_post();
    $last_alpha = hs_maybe_start_new_letter( $last_alpha );
    the_title( "    <li aria-hidden='false'><a href=\"" . esc_url( get_permalink() ) . '" rel="bookmark">', "</a></li>\n" );
  }
  hs_end_letter();
?>

      </section>
    </section><!-- .entry-content -->

<?php
  hs_list_page_footer();
} else {
  get_template_part( 'template-parts/content', 'none' );
}
?>

  </main><!-- #main -->

<?php
get_footer();
