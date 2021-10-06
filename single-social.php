<?php
/**
 * The template for displaying social media posts.
 * This is for preview only - social media posts are only displayed to the world in posts panels.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package homesite-2017
 */

if ( have_posts() ) {
  the_post();

  // create variables $title, $content, $excerpt, $image, $link, $post_type, $post_id
  $post_data = [
      'post_id'   => get_the_ID()
    , 'title'     => get_the_title()
    , 'content'   => get_the_content()
    , 'excerpt'   => get_the_excerpt()
    , 'image'     => get_post_thumbnail_id()
    , 'link'      => []
    , 'post_type' => 'social'
  ];

  get_header();
?>

  <main id="main" role="main">

    <h2 id="main-content" class="sr-only-element" tabindex="-1">Main Content</h2>
    <header>
      <?php the_title( "<h1>", "</h1>\n" ); ?>
    </header><!-- .entry-header -->

    <section class="panel theme--fog" data-type="posts" data-width="full" data-posts-per-row="4" data-feature-first-post="false">
      <div class="grid-container">
        <?php hs_render_social_post( $post_data ); ?>
      </div>
    </section>

  </main><!-- #main -->

<?php
  get_footer();

} else {
  get_template_part( '404' );
}
