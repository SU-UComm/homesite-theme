<section class="entry-content">
  <p class="fa fa-exclamation-triangle alert-icon" aria-hidden="true"></p>
<?php
  the_content();
  hs_render_panels( 'main' );
  if ( has_post_thumbnail() ) {
    $img_id = get_post_thumbnail_id();
    hs_render_image( $img_id, [
        'show_caption' => FALSE
      , 'show_credit'  => FALSE
      , 'img_attrs'    => [ 'class' => 'bg-img' ]
      , 'fig_attrs'    => [ 'class' => 'bg-wrapper' ]
    ] );
  }
?>
</section><!-- .entry-content -->
