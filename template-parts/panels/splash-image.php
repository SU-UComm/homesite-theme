<?php
$panel_vars = get_panel_vars();

$image_landscape = _hs_get_image_data( $panel_vars[ 'image_landscape' ] );
$image_portrait  = _hs_get_image_data( $panel_vars[ 'image_portrait'  ] );
$source          = _hs_picture_source_lp( $image_landscape[ 'srcset' ], $image_portrait[ 'srcset'] );

/**
 * Available data in $image_landscape and $image_portrait:
 * 'uri', 'width', 'height', 'srcset', 'caption', 'credit', 'raw-credit', 'alt'
 *
 * Examples:
 * echo $image_landscape[ 'uri'    ]; // emits the uri   for the image
 * echo $image_landscape[ 'srcset' ]; // emits the srcset for the image
 * echo $image_landscape[ 'alt'    ]; // emits the image's alt text
 *
 * Note:
 * 'credit' and 'raw-credit' are dummy text for now
 */
?>
<?php
if ( $panel_vars[ 'logo' ] != "no-logo" ) {
  $watermark_classes = [
      "su-brand"
    , "splash__wordmark--" . $panel_vars[ 'logo_placement_vertical' ] // top, middle or bottom
    , "splash__wordmark--" . $panel_vars[ 'logo_placement_horizontal' ] // left, center or right
  ];
  if ( $panel_vars[ 'logo' ] == "watermark-logo" ) {
    $watermark_classes[] = "splash__wordmark--watermark ";
  }
?>
<p id="splash--wordmark" class="<?php echo implode( ' ', $watermark_classes ); ?>">Stanford</p>
<?php
}
?>
<?php if ( !empty( $panel_vars[ 'scroll_cta' ] ) ) { ?>
<p id="splash--scroller"><a href="#main-content" data-ga-action="Splash screen scroller"><?php echo $panel_vars[ 'scroll_cta' ]; ?></a></p>
<?php } ?>

  <?php if (!empty( $panel_vars[ 'video_url'])) { ?>
        <video id="splash-video" class="bg-img" role="region" muted loop preload="auto" aria-label="decorative video" poster="<?php echo $image_landscape[ 'uri' ]; ?>">
            <source src="<?php echo $panel_vars[ 'video_url' ]; ?>" type="video/mp4" />
        </video>
      <button aria-label="Pause" type="button" id="splash--pause">
          <i class="fa fa-pause-circle"></i>
      </button>
  <?php } else { ?>
    <picture aria-hidden="true" tabindex="-1">
      <!--[if IE 9]><video style="display: none;"><![endif]-->
      <?php echo $source; ?>
      <!--[if IE 9]></video><![endif]-->
      <img class="bg-img" role="presentation" alt="" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
    </picture>
   <?php } ?>

