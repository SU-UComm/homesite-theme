<?php
$panel_vars = get_panel_vars();

if ( !empty( @$panel_vars[ 'bg_images' ][ 'landscape' ] ) ) {
  $bg_img_landscape = _hs_get_image_data( $panel_vars[ 'bg_images' ][ 'landscape' ] );

  if ( !empty( @$panel_vars[ 'bg_images' ][ 'portrait' ] ) ) {
    $bg_img_source = _hs_picture_source_lp( $bg_img_landscape[ 'srcset' ], $panel_vars[ 'bg_images' ][ 'portrait' ] );
  } else {
    $bg_img_source = _hs_picture_source_lp( $bg_img_landscape[ 'srcset' ], NULL );
  }
}


hs_panel_header( $panel_vars );

$panel    = get_the_panel();
$children = $panel->get_children();
foreach ( $children as $child ) {
  echo $child->render();
}

hs_panel_footer( $panel_vars );

if ( !empty( $bg_img_source ) ) {
  $bg_attrs = [
      'data-img-anchor-v' => ( isset( $panel_vars[ 'bg_images' ][ 'anchor_v' ] ) && !empty( $panel_vars[ 'bg_images' ][ 'anchor_v' ] ) ) ? $panel_vars[ 'bg_images' ][ 'anchor_v' ] : 'center'
    , 'data-img-anchor-h' => ( isset( $panel_vars[ 'bg_images' ][ 'anchor_h' ] ) && !empty( $panel_vars[ 'bg_images' ][ 'anchor_h' ] ) ) ? $panel_vars[ 'bg_images' ][ 'anchor_h' ] : 'center'
    , 'data-gradient'     => ( isset( $panel_vars[ 'bg_images' ][ 'gradient' ] ) && !empty( $panel_vars[ 'bg_images' ][ 'gradient' ] ) ) ? $panel_vars[ 'bg_images' ][ 'gradient' ] : 'none'
  ];
?>
<div class="img-container" <?php echo _hs_build_attrs( $bg_attrs ); ?>>
  <picture>
    <!--[if IE 9]><video style="display: none;"><![endif]-->
    <?php echo $bg_img_source; ?>
    <!--[if IE 9]></video><![endif]-->
    <img class="bg-img" role="presentation" alt="" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
  </picture>
</div>
<?php
}