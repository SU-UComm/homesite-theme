<?php
$panel_vars = get_panel_vars();

hs_panel_header( $panel_vars );
?>
<div class="grid-container">
<?php
$i = 1;
foreach ( $panel_vars[ 'the_posts' ] as $the_post ) {
  hs_render_post( $the_post, $i++, $panel_vars );
}
?>
</div>
<?php hs_panel_footer( $panel_vars ); ?>
