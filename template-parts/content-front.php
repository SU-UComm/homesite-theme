<?php
if ( have_panels() ) {
  hs_render_panels( 'main' );
} else {
  get_template_part( 'template-parts/content', 'page' );
}
?>
