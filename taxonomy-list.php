<?php
/**
 * The template for displaying lists of websites.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package homesite-2017
 */

$current_term  = get_queried_object();
$current_tax   = get_taxonomy( $current_term->taxonomy );
$child_terms   = get_terms( [
    'taxonomy'   => $current_tax->name
  , 'parent'     => $current_term->term_id
  , 'hide_empty' => FALSE
  ] );

$filters = hs_get_filters( $child_terms );

get_header();
?>

  <main id="main" class="site-main" role="main">
    <h2 id="main-content" class="sr-only-element" tabindex="-1">Main Content</h2>

<?php
if ( have_posts() ) {
?>

    <header>
      <h1><?php echo $current_term->name;?></h1>
      <?php the_archive_description( '<section>', '</section>' ); ?>
    </header>

    <section class="entry-content">
      <?php hs_maybe_emit_filters( $filters ); ?>
      <section id="list" data-ga-category="Department / unit list">
        <h2 class="sr-only-element" tabindex="-1">List of websites</h2>

<?php
  $last_alpha = '';
  while ( have_posts() ) {
    the_post();

    $last_alpha = hs_maybe_start_new_letter( $last_alpha );

    $sublists = [];
    if ( !empty( $filters ) ) {
      $terms = wp_get_post_terms( get_the_ID(), $current_tax->name );
      foreach ( $terms as $the_term ) {
        if ( isset( $filters[ $the_term->slug ] ) ) {
          $sublists[] = $the_term->slug;
        }
      }
    }
    $data = ( empty( $sublists) ) ? '' : ' data-filter="' . implode( ' ', $sublists ) . '"';

    the_title( "    <li {$data} aria-hidden='false'><a href=\"" . esc_url( get_permalink() ) . '" rel="bookmark">', "</a></li>\n" );
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
get_sidebar();
get_footer();
