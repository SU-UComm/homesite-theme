<?php
$panel_vars = get_panel_vars();

$caption = trim( $panel_vars[ 'text' ] );

$fig_data  =  "data-text-loc-v=\"{$panel_vars[ 'text_placement_vertical'   ]}\"";
$fig_data .= " data-text-loc-h=\"{$panel_vars[ 'text_placement_horizontal' ]}\"";
if ( !empty( $panel_vars[ 'text_display' ] ) && $panel_vars[ 'text_display' ] != 'always' ) {
  $fig_data .= " data-text-display=\"{$panel_vars[ 'text_display' ]}\"";
}

if ( !empty( @$panel_vars[ 'image_large' ] ) ) {
  $image_large = _hs_get_image_data( $panel_vars[ 'image_large' ] );

  if ( !empty( @$panel_vars[ 'image_small' ] ) ) {
    $image_small = _hs_get_image_data( $panel_vars[ 'image_small' ] );
    $source = _hs_picture_source( $image_large[ 'srcset' ], $image_small[ 'srcset'] );
  } else {
    $source = _hs_picture_source( $image_large[ 'srcset' ], NULL );
  }
}

/**
 * Available data in $image_large and $image_small:
 * 'uri', 'width', 'height', 'srcset', 'caption', 'credit', 'raw-credit', 'alt'
 *
 * Examples:
 * echo $image_large[ 'uri'    ]; // emits the uri   for the image
 * echo $image_large[ 'srcset' ]; // emits the srcset for the image
 * echo $image_large[ 'alt'    ]; // emits the image's alt text
 *
 * Note:
 * 'credit' and 'raw-credit' are dummy text for now
 */
?>

<?php if ( !empty( $source ) ) { ?>
<figure <?php echo $fig_data; ?>>
  <picture>
    <!--[if IE 9]><video style="display: none;"><![endif]-->
    <?php echo $source; ?>
    <!--[if IE 9]></video><![endif]-->
    <img alt="<?php echo $image_large[ 'alt' ]; ?>" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
  </picture>
  <?php if ( !empty( $caption ) ) { ?>
  <figcaption><?php echo $panel_vars[ 'text' ]; ?></figcaption>
  <?php } ?>
</figure><!-- hero-image -->
<?php } ?>
