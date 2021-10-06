<?php
$panel_vars = get_panel_vars();

hs_panel_header( $panel_vars );
?>
<div class="content">
  <?php echo apply_filters( 'the_content', $panel_vars[ 'content'] ); ?>
</div>
<?php
$panel    = get_the_panel();
$children = $panel->get_children();
foreach ( $children as $child ) {
  echo $child->render();
}