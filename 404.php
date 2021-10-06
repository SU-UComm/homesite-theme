<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package homesite-2017
 */

$links = <<<EOLINKS
<ul>
  <li><a href="/">Stanford Homepage</a></li>
  <li><a href="/search">Search Stanford</a></li>
</ul>
EOLINKS;
$inline_links = hs_shortcode_inline_links( [ 'size' => 'large' ], $links );

get_header();
?>

  <main id="main" role="main">
    <h2 id="main-content" class="sr-only-element" tabindex="-1">Main Content</h2>

    <section class="entry-content">
      <header>
        <h1>Hmmm&hellip;we can't find that page.</h1>
      </header>

      <p>
        It may have moved or may no longer exist.  If you reached this error from a link on our site,
        please <a href="https://stanford.service-now.com/services?id=get_help&cmdb_ci=915f10561329474019813598d144b00f">leave us feedback</a>, so we can fix the problem.
        Regardless, let's help you get where you want to go.
      </p>

      <?php
      echo $inline_links;
      hs_render_404_bg_img();
      ?>

    </section><!-- .entry-content -->

  </main><!-- #main -->

<?php
get_footer();
