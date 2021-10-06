<?php
$is_search_page = is_page_template( 'search.php' );
$search_term = ( $is_search_page && isset( $_REQUEST[ 'q' ] ) && !empty( $_REQUEST[ 'q' ] ) ) ? esc_attr( $_REQUEST[ 'q' ] ) : '';
?>
<section id="search-wrapper">
  <div id="search-overlay" aria-hidden="true" role="presentation"></div>
  <div id="site-search" role="search">
    <?php hs_search_form( 'web', $search_term ); ?>
    <p>
      Other ways to search:
        <a href="https://campus-map.stanford.edu/">Map</a>
        <a href="https://profiles.stanford.edu/">Profiles</a>
    </p>
  </div>
</section>
