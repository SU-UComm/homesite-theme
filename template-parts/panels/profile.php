<?php
$panel_vars = get_panel_vars();

$attrib_photo = wp_get_attachment_image( $panel_vars[ 'attrib' ][ 'photo' ], 'thumbnail' );

if ( !empty( @$panel_vars[ 'bg_images' ][ 'landscape' ] ) ) {
  $bg_img_landscape = _hs_get_image_data( $panel_vars[ 'bg_images' ][ 'landscape' ] );

  if ( !empty( @$panel_vars[ 'bg_images' ][ 'portrait' ] ) ) {
    $bg_img_source = _hs_picture_source_lp( $bg_img_landscape[ 'srcset' ], $panel_vars[ 'bg_images' ][ 'portrait' ] );
  } else {
    $bg_img_source = _hs_picture_source_lp( $bg_img_landscape[ 'srcset' ], NULL );
  }
}
/**
 * Available data in the image arrays:
 * 'uri', 'width', 'height', 'srcset', 'caption', 'credit', 'raw-credit', 'alt'
 *
 * Examples:
 * echo $image_large[ 'uri'    ]; // emits the uri   for the image
 * echo $image_small[ 'srcset' ]; // emits the srcset for the image
 * echo $image_large[ 'alt'    ]; // emits the image's alt text
 *
 * Note:
 * 'credit' and 'raw-credit' are dummy text for now
 */
?>

<h2 class="sr-only-element">Profile of <?php echo $panel_vars[ 'attrib' ][ 'headline' ]; ?></h2>
<?php if ( !empty( $bg_img_source ) ) { ?>
  <picture aria-hidden="true" tabindex="-1">
    <!--[if IE 9]><video style="display: none;"><![endif]-->
    <?php echo $bg_img_source; ?>
    <!--[if IE 9]></video><![endif]-->
    <img class="bg-img" role="presentation" alt="" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"/>
  </picture>
<?php } ?>
<div class="content">
  <?php if ( !empty( $panel_vars[ 'topic' ] ) ) echo "<h3>{$panel_vars[ 'topic' ]}</h3>\n"; ?>
  <?php echo $attrib_photo; ?>
  <?php echo $panel_vars[ 'text' ]; ?>
  <div class="attribution">
    <h3><?php echo $panel_vars[ 'attrib' ][ 'headline' ]; ?></h3>
    <p><?php  echo $panel_vars[ 'attrib' ][ 'details'  ]; ?></p>
    <?php if ( is_array( @$panel_vars[ 'attrib' ][ 'link' ] ) ) hs_jump_link( $panel_vars[ 'attrib' ][ 'link' ] ); ?>
  </div>
</div>
