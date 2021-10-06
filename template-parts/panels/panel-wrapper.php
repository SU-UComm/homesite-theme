<?php

/**
 * A customized wrapper around each modular panel.
 *
 * IMPORTANT: the data attributes are REQUIRED for the live preview iframe to function.
 *
 * @var \ModularContent\Panel $panel
 * @var int $index 0-based count of panels rendered thus far
 * @var string $html The rendered HTML of the panel
 */

if ( !empty( trim( $html ) ) ) {

  $panel_vars  = $panel->get_template_vars();
  $panel_attrs = [
      'class'     => 'panel'
    , 'data-type' => esc_attr( $panel->get( 'type' ) )
  ];

  // extra attributes for stand-alone and parent panels - necessary for Live Preview
  if ( $panel->get_depth() == 0 ) {
    $panel_attrs[ 'data-modular-content' ] = NULL;
    $panel_attrs[ 'data-js'              ] = 'panel';
    $panel_attrs[ 'data-index'           ] = $index;
  }

  // handle standard panel options
  if ( !empty( $panel_vars[ 'theme' ] ) && $panel_vars[ 'theme' ] != 'inherit' ) {
    $panel_attrs[ 'class' ] .= " theme--" . esc_attr( $panel_vars[ 'theme' ] );
  }

  $content_width = @$panel_vars[ 'content_width' ];
  if ( ! empty( $content_width ) ) {
    $panel_attrs[ 'data-width' ] = esc_attr( $content_width ) ;
  }

  if ( isset( $panel_vars[ 'posts_across' ] ) ) {
    $panel_attrs[ 'data-posts-per-row' ] = !empty( trim( $panel_vars[ 'posts_across' ] ) ) ? esc_attr( $panel_vars[ 'posts_across' ] ) : '3';
  }

  // handle specific panel types
  $panel_type = $panel->get_type_object()->get_id();
  switch ( $panel_type ) {
    case 'accordion':
      foreach ( $panel_vars[ 'initial_state' ] as $breakpoint => $state ) {
        $panel_attrs[ 'data-init-' . $breakpoint ] = esc_attr( $state );
      }
      break;
    case 'image-content':
      $panel_attrs[ 'data-img-loc' ] = esc_attr( $panel_vars[ 'img_loc' ] );
      break;
    case 'posts':
      $panel_attrs[ 'data-featured-post' ] = ( isset( $panel_vars[ 'featured_post' ] ) && !empty( $panel_vars[ 'featured_post' ] ) ) ? $panel_vars[ 'featured_post' ] : 'none';
      break;
    case 'profile':
      if ( !empty( @$panel_vars[ 'bg_images' ][ 'landscape' ] ) )  {
        $panel_attrs[ 'data-bg-img' ] = 'true';
      }
      break;
    case 'section-bg':
      $padding_top = @$panel_vars[ 'padding_top' ];
      if ( ! empty( $padding_top ) ) {
        $panel_attrs[ 'data-pad-top' ] = esc_attr( $padding_top );
      }
      $padding_bottom = @$panel_vars[ 'padding_bottom' ];
      if ( ! empty( $padding_bottom ) ) {
        $panel_attrs[ 'data-pad-bottom' ] = esc_attr( $padding_bottom );
      }
      break;
    case 'splash-image':
      $scroll_type = ( isset( $panel_vars[ 'scroll_type' ] ) && !empty( $panel_vars[ 'scroll_type' ] ) ) ? $panel_vars[ 'scroll_type' ] : 'curtain';
      $panel_attrs[ 'data-scroll-type' ] = esc_attr( $scroll_type );
      $panel_attrs[ 'data-logo-loc-v'  ] = esc_attr( $panel_vars[ 'logo_placement_vertical'   ] );
      $panel_attrs[ 'data-logo-loc-h'  ] = esc_attr( $panel_vars[ 'logo_placement_horizontal' ] );
      $panel_attrs[ 'data-ga-category' ] = 'Splash Panel';
      break;
    case 'well':
      $panel_attrs[ 'data-color' ] = esc_attr( $panel_vars[ 'stroke_color' ] );
      break;
  }
  ?>

  <section <?php echo _hs_build_attrs( $panel_attrs ); ?>>

    <?php echo $html; ?>

  </section><!-- panel <?php echo $panel_vars[ 'title' ]; ?> -->

<?php
}
?>

