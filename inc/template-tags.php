<?php

use \Stanford\Homesite\Post_Types\News   as News;
use \Stanford\Homesite\Post_Types\Social as Social;

/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package homesite-2017
 */

/** @var int at browser widths >= HS_LG_IMG_MIN_WIDTH, we should display large images */
define( 'HS_LG_IMG_MIN_WIDTH', 575 );

/******************************************************************************
 *  Stanford template tags - all function names start with hs_ (for homesite)
 */

/**
 * Look through all the panels on a page and sort them based on where they should
 * be emitted: either in  <header>, <main>, sidebar (<aside>) or <footer>. This
 * function should be called at the top of every page and post template.
 *
 * @var array $hs_post_panels
 */
function hs_sort_panels_by_region() {
  global $hs_post_panels;
  $hs_post_panels = [
      'header'  => []
    , 'main'    => []
    , 'sidebar' => []
    , 'footer'  => []
  ];

  if ( function_exists('have_panels') && have_panels() ) {
    // grab all the panels
    while ( have_panels() ) {
      the_panel();
      $panel      = get_the_panel();
      $panel_vars = $panel->get_template_vars();
      if ( empty ( @$panel_vars[ 'page_location' ] ) ) {
        $panel_vars[ 'page_location' ] = 'main';
      }
      $hs_post_panels[ $panel_vars[ 'page_location' ] ][] = $panel;
    }
    rewind_panels();
  }
}

/**
 * If there's a splash panel on the page we're rendering, return a class name indicating
 * its scroll behavior.
 *
 * @return string 'splash-curtain' or 'splash-parallax'
 */
function hs_get_splash_panel_type() {
  global $hs_post_panels;
  if ( is_array( $hs_post_panels ) && !empty( $hs_post_panels) ) {
    foreach ( $hs_post_panels as $section => $section_panels ) {
      foreach ( $hs_post_panels[ $section ] as $panel ) {
        $panel_id = $panel->get_type_object()->get_id();
        if ( is_numeric( strpos( $panel_id, 'splash' ) ) ) {
          $panel_vars = $panel->get_template_vars();
          $scroll_type = isset( $panel_vars[ 'scroll_type' ] ) ? $panel_vars[ 'scroll_type' ] : 'curtain';
          return "splash-{$scroll_type}";
        }
      }
    }
  }
  return [];
}

/**
 * Render the panels appropriate for the specified region: one of 'header', 'main', 'footer'.
 * This function should be called three times in every page and post template: once while
 * emitting the <header>, once while emitting <main>, and once while emitting the <footer>.
 *
 * @see hs_sort_panels_by_region()
 *
 * @var array  $hs_post_panels *
 * @param  string $region - one of 'header', 'main', 'footer'
 */
function hs_render_panels( $region ) {
  global $hs_post_panels;
  if ( empty( $hs_post_panels[ $region ] ) ) return;

  $panels = '';
  foreach ( $hs_post_panels[ $region ] as $panel ) {
    $panels .= $panel->render();
  }
  $template = locate_template( 'template-parts/panels/collection-wrapper.php' );
  if ( $template ) {
    include( $template );
  } else {
    echo $panels;
  }
}

/**
 * Emit correct markup for panel's <header> based on panel settings
 * <header> includes:
 *   - title
 *   - intro text
 *
 * @param array $panel_vars returned by get_panel_vars()
 */
function hs_panel_header( $panel_vars ) {
  $show_title      = @$panel_vars[ 'show_title' ] == 'yes';
  $show_intro_text = !empty( trim( @$panel_vars[ 'wrapper_text' ][ 'intro' ] ) );

  if ( $show_title || $show_intro_text ) {
    echo "<header>\n";
    hs_panel_icon(       $panel_vars );
    hs_panel_title(      $panel_vars );
    hs_panel_intro_text( $panel_vars );
    echo "</header>\n";
  }
}

/**
 * Emit correct markup for panel's <footer> based on panel settings
 * <footer> includes:
 *   - closing text
 *
 * @param array $panel_vars returned by get_panel_vars()
 */
function hs_panel_footer( $panel_vars ) {
  $show_closing_text = !empty( trim( @$panel_vars[ 'wrapper_text' ][ 'closing' ] ) );

  if ( $show_closing_text ) {
    echo "<footer>\n";
    hs_panel_closing_text( $panel_vars );
    echo "</footer>\n";
  }
}

/**
 * Emit correct markup for panel icon based on panel settings
 *
 * @param array $panel_vars returned by get_panel_vars()
 */
function hs_panel_icon( $panel_vars ) {
  $icon   = isset( $panel_vars[ 'fa_icon' ] ) ? trim( $panel_vars[ 'fa_icon' ] ) : '';
  $center = ( @$panel_vars[ 'center_title' ] == 'yes' ) ? 'center' : '';

  if ( !empty( $icon ) ) {
    echo "\n<div class='fa {$icon} {$center}' aria-hidden='true'></div>\n";
  }
}

/**
 * Emit correct markup for panel title based on panel settings
 *
 * @param array $panel_vars returned by get_panel_vars()
 */
function hs_panel_title( $panel_vars ) {
  $show_title  = ( @$panel_vars[ 'show_title' ]   == 'yes' );
  $title_class = ( @$panel_vars[ 'center_title' ] == 'yes' ) ? 'class="center"' : '';

  if ( $show_title ) {
    echo "\n<h2 {$title_class}>{$panel_vars[ 'title' ]}</h2>\n";
  }
}

/**
 * Emit correct markup for panel intro text
 *
 * @param array $panel_vars returned by get_panel_vars()
 */
function hs_panel_intro_text( $panel_vars ) {
  $intro_text = trim( @$panel_vars[ 'wrapper_text' ][ 'intro' ] );
  if ( !empty( $intro_text ) )  {
    echo wpautop( $intro_text ) . "\n";
  }
}

/**
 * Emit correct markup for panel closing text
 *
 * @param array $panel_vars returned by get_panel_vars()
 */
function hs_panel_closing_text( $panel_vars ) {
  $closing_text = trim( @$panel_vars[ 'wrapper_text' ][ 'closing' ] );
  if ( !empty( $closing_text ) ) {
    echo wpautop( $closing_text ) . "\n";
  }
}

/**
 * Emit the markup for a jump link.
 *
 * @param array $link data from Panel Builder's Link field
 */
function hs_jump_link( $link ) {
  if ( is_array( $link ) && !empty( $link[ 'url' ] ) ) {
    echo hs_shortcode_jump_link( [ 'url' => $link[ 'url' ] ], $link[ 'label' ] );
  }
}

/**
 * If there are any widgets in the Alert area, emit them
 */
function hs_render_alerts() {
  if ( is_active_sidebar( HS_ALERT_SIDEBAR ) ) {
    dynamic_sidebar( HS_ALERT_SIDEBAR );
  }
}

function hs_render_404_bg_img() {
  global $wpdb;
  $img_ids = [];

  $sql_fmt = <<< EOSQL
SELECT ID
  FROM {$wpdb->posts}
 WHERE post_title  = '404-%s'
   AND post_type   = 'attachment'
   AND post_status = 'inherit'
;
EOSQL;
  foreach ( [ 'landscape', 'portrait' ] as $orientation ) {
    $sql = sprintf( $sql_fmt, $orientation );
    $ids = $wpdb->get_col( $sql );
    if ( empty( $ids ) ) continue;
    $img_ids[ $orientation ] = $ids[0];
  }
  if ( empty( $img_ids ) ) return;
  if ( !isset( $img_ids[ 'landscape' ] ) ) $img_ids[ 'landscape' ] = $img_ids[ 'portrait' ];

  $img_source = _hs_picture_source_lp( $img_ids[ 'landscape' ], @$img_ids[ 'portrait' ] );
?>
<figure class="bg-wrapper">
  <picture aria-hidden="true" tabindex="-1">
    <!--[if IE 9]><video style="display: none;"><![endif]-->
    <?php echo $img_source; ?>
    <!--[if IE 9]></video><![endif]-->
    <img class="bg-img" role="presentation" alt="" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
  </picture>
  </figure>
<?php
}

/**
 * Emit the proper markup for an image with a srcset and an optional caption / credit
 * Accepts the following options in the $opts array:
 *   'show_caption' => TRUE | FALSE | caption text (to override what's stored in the Media Library)
 *   'show_credit'  => TRUE | FALSE
 *   'fixed_ar'     => TRUE | FALSE (should the image have a fixed aspect ratio?)
 *   'aspect_ratio' => one of '1:1', '3:2', '5:2', '8:5', '16:9', '2:3' - required if fixed_ar => TRUE
 *   'ar_overflow'  => one of 'vertical', 'horizontal'
 *   'fig_attrs'    => additional attributes for the <figure>
 *   'pic_attrs'    => additional attributes for the <picture>
 *   'img_attrs'    => additional attributes for the <img>
 *   'a_attrs'      => attributes for the optional <a> tag - include 'href' => url if the image should be linked
 *   'echo'         => TRUE | FALSE - if TRUE, echo the output before returning it
 *
 * @param int   $id   id of image to be rendered
 * @param array $opts see details above
 * @return string HTML for an image with srcset and optional caption
 */
function hs_render_image( $id, $opts = [] ) {
  $opts = shortcode_atts( [
      'show_caption' => TRUE
    , 'show_credit'  => TRUE
    , 'fixed_ar'     => FALSE
    , 'aspect_ratio' => '3:2'
    , 'ar_overflow'  => 'vertical'
    , 'fig_attrs'    => []
    , 'pic_attrs'    => []
    , 'img_attrs'    => []
    , 'a_attrs'      => []
    , 'echo'         => TRUE
  ], $opts );

  $img = _hs_get_image_data( $id, 'orig' );
  if ( empty( $img ) ) return;

  if ( empty( $img[ 'srcset' ] ) ) {
    $img[ 'srcset' ] = $img[ 'uri' ];
  }

  $orientation = $img[ 'height' ] > $img[ 'width' ] ? 'portrait' : 'landscape';
  if ( isset( $opts[ 'fig_attrs' ][ 'class' ] ) && !empty( $opts[ 'fig_attrs' ][ 'class' ] ) ) {
    $opts[ 'fig_attrs' ][ 'class' ] .= " {$orientation}";
  } else {
    $opts[ 'fig_attrs' ][ 'class' ]  = $orientation;
  }

  if ( $opts[ 'fixed_ar'] ) {
    $opts[ 'fig_attrs' ][ 'data-ar' ]          = $opts[ 'aspect_ratio' ];
    $opts[ 'fig_attrs' ][ 'data-ar-overflow' ] = $opts[ 'ar_overflow' ];
  }

  if ( !isset( $opts[ 'img_attrs' ][ 'alt' ] ) ) {
    $opts[ 'img_attrs' ][ 'alt' ] = $img[ 'alt' ];
  }
  if ( !isset( $opts[ 'img_attrs' ][ 'src' ] ) ) { // <img>'s without src attrs don't validate
    $opts[ 'img_attrs' ][ 'src' ] = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
  }

  $caption = '';
  if ( $opts[ 'show_caption'] ) {
    if ( is_string( $opts[ 'show_caption' ] ) ) { // if we were given the caption text
      $caption = $opts[ 'show_caption' ];
    } elseif ( !empty( $img[ 'caption' ] ) ) { // otherwise use the caption from the Media Library, if any
      $caption .= $img[ 'caption' ];
    }
  }
  if ( $opts[ 'show_credit']  && !empty( $img[ 'credit'  ] ) ) {
    $caption .= " " . $img[ 'credit' ];
  }
  if ( !empty( $caption ) ) {
    $caption = "<figcaption>" . trim($caption) . "</figcaption>";
  }

  $fig_attributes = _hs_build_attrs( $opts[ 'fig_attrs' ] );
  $pic_attributes = _hs_build_attrs( $opts[ 'pic_attrs' ] );
  $img_attributes = _hs_build_attrs( $opts[ 'img_attrs' ] );

  if ( !empty( $opts[ 'a_attrs' ] ) && !empty( @$opts[ 'a_attrs' ][ 'href' ] ) ) {
    $open_link  = "<a " . _hs_build_attrs( $opts[ 'a_attrs' ] ) . ">";
    $close_link = "</a>";
  } else {
    $open_link  = '';
    $close_link = '';
  }

  $html = <<<EOIMGHTML
<figure {$fig_attributes}>
  {$open_link}
  <picture {$pic_attributes}>
    <!--[if IE 9]><video style="display: none;"><![endif]-->
    <source srcset="{$img[ 'srcset' ]}" />
    <!--[if IE 9]></video><![endif]-->
    <img {$img_attributes} />
  </picture>
  {$close_link}
  {$caption}
</figure>

EOIMGHTML;

  if ( $opts[ 'echo' ] ) echo $html;
  return $html;
}

/**
 * Emit the markup to render one highlight from the Highlights panel
 *
 * @param array $highlight [ 'highlight_title', 'highlight_image', 'highlight_content', 'highlight_link' ]
 */
function hs_render_highlight( $highlight ) {
  extract( $highlight ); // creates variables $highlight_title, $highlight_image, $highlight_content and $highlight_link

  $url = ( is_array( @$highlight_link ) && !empty( @$highlight_link[ 'url' ] ) )
       ? esc_attr( $highlight_link[ 'url' ] )
       : NULL;

  echo "<section class='highlight'>\n";

  if ( isset( $highlight_image ) && is_numeric( $highlight_image ) && $highlight_image > 0 ) {
    hs_render_image( $highlight_image, [
        'show_caption' => FALSE
      , 'show_credit'  => FALSE
      , 'fixed_ar'     => FALSE // it is fixed_ar, but the ar is forced in the css for the highlights panel
      , 'img_attrs'    => [ "role" => "presentation" ]
    ] );
  }

	if ( !empty( @$highlight_title ) ) {
		echo "<h3>" . sanitize_text_field( $highlight_title ) . "</h3>\n";
	}

	if ( !empty( @$highlight_content ) ) {
		echo apply_filters( 'the_content', trim( $highlight_content ) ) . "\n";
	}

	if ( is_array( @$highlight_link ) & !empty( @$highlight_link[ 'url' ] ) ) {
		echo "<p class=\"highlight-link\">";
		hs_jump_link( $highlight_link );
		echo "</p>\n";
	}

	echo "</section>\n";
}

/**
 * Emit the markup to render one of the posts from Panel Builder's Post_List field
 *
 * @param array $post [ 'title', 'content', 'excerpt', 'image', 'link', 'post_type', 'post_id' ]
 * @param int   $post_num which post in the list we're emitting (so we can feature the first one)
 * @param array $panel_vars - so we know whether to display the post's category and / or date
 */
function hs_render_post( $post, $post_num, $panel_vars ) {
  // social posts render slightly differently
  if ( $post[ 'post_type' ] == Social::NAME ) {
    hs_render_social_post( $post );
    return;
  }

  // first, get all the info we (might) need
  extract( $post ); // create variables $title, $content, $excerpt, $image, $link, $post_type, $post_id

  // we should always have a link, but test just to be safe
  if ( is_array( @$link ) && !empty( $link[ 'url' ] ) ) {
    $title_fmt = "    <h3><a href='" . esc_attr( urldecode( $link[ 'url' ] ) ) . "'>%s</a></h3>\n";
  } else {
    $title_fmt = "    <h3>%s</h3>";
  }

  $show_categories     = ( @$panel_vars[ 'show_categories' ] == 'yes'   );
  $show_dates          = ( @$panel_vars[ 'show_dates' ]      == 'yes'   );
  $show_excerpts       = ( @$panel_vars[ 'show_excerpts' ]   == 'yes'   );
  $featured_first      = ( @$panel_vars[ 'featured_post' ]   == 'first' ) && ( $post_num == 1 );
  $featured_first_last = ( @$panel_vars[ 'featured_post' ]   == 'first-last' ) && ( ( $post_num == 1 ) || ( $post_num == 6 ) );

  $category = '';
  if ( $show_categories ) {
    $categories = get_the_category( $post_id );
    foreach ( $categories as $term ) {
      if ( $term->slug == 'uncategorized' ) continue;
      $category = $term->name;
      if ( $term->slug != 'research' ) break;
    }
  }

  $date = '';
  if ( $show_dates ) {
    $date = get_the_date( '', $post_id );
  }

  $custom_fields = get_post_meta( $post_id );
  $img_anchor_v  = @$custom_fields[ News::get_field_id( 'anchor-v' ) ][ 0 ];
  $img_anchor_h  = @$custom_fields[ News::get_field_id( 'anchor-h' ) ][ 0 ];

  if ( $featured_first ) {
    // get the data for when this post is a featured post
    $lg_image   = @$custom_fields[ News::get_field_id( 'lg-img_id'        ) ][ 0 ];
    $text_loc_v = @$custom_fields[ News::get_field_id( 'text-placement-v' ) ][ 0 ];
    $text_loc_h = @$custom_fields[ News::get_field_id( 'text-placement-h' ) ][ 0 ];

    if ( is_numeric( $lg_image ) ) {
      $image = $lg_image;
    }
    $article_attrs = [
        'data-text-loc-v' => !empty( $text_loc_v ) ? $text_loc_v : 'bottom'
      , 'data-text-loc-h' => !empty( $text_loc_h ) ? $text_loc_h : 'left'
    ];
  } elseif ( $featured_first_last ) {
    $theme = @$custom_fields[ News::get_field_id( 'theme'    ) ][ 0 ];

    $article_attrs = [
        'class' => 'theme--' . ( !empty( $theme ) ? $theme : 'choco' )
    ];
  } else {
    $article_attrs = [];
  }

  /*****************
   * emit the markup
   */

  echo "<article " . _hs_build_attrs( $article_attrs ) . ">\n";

  if ( isset( $image ) && is_numeric( $image ) && $image > 0 ) {
    hs_render_image( $image, [
        'show_caption' => FALSE
      , 'show_credit'  => FALSE
      , 'fixed_ar'     => FALSE // it is fixed_ar, but the ar is forced in the css for the posts panel
      , 'pic_attrs'    => [
            'data-anchor-v' => !empty( $img_anchor_v ) ? $img_anchor_v : 'center'
          , 'data-anchor-h' => !empty( $img_anchor_h ) ? $img_anchor_h : 'center'
        ]
      , 'a_attrs'      => [
            'href'        => trim( $link[ 'url' ] )
          , 'aria-hidden' => 'true'
          , 'tabindex'    => '-1'
        ]
      , 'img_attrs'    => [
            'role'        => 'presentation'
        ]
    ] );
  }

  echo "  <div class='content'>\n";

  if ( !empty( $category ) || !empty( $date ) ) {
    echo "    <div class=\"post-meta\">\n";
    if ( !empty( $category ) ) echo "      <p class=\"post-category\">{$category}</p>\n";
    if ( !empty( $date )     ) echo "      <p class=\"post-date\">{$date}</p>\n";
    echo "    </div>\n";
  }

  if ( !empty( @$title ) ) {
    printf( $title_fmt, $title );
  }

  if ( $show_excerpts ) {
    if ( ! empty( @$excerpt ) ) {
      echo "  " . wpautop( trim( $excerpt ) ) . "\n";
    } elseif ( ! empty( @$content ) ) {
      echo "  {$content}\n";
    }
  }

  echo "  </div>\n";

  echo "</article>\n";
}

/**
 * Emit the markup to render one of the posts from Panel Builder's Post_List field as a Highlight
 *
 * @param array $post [ 'title', 'content', 'excerpt', 'image', 'link', 'post_type', 'post_id' ]
 */
function hs_render_social_post_HIDE( $post ) {
  $url = trim( get_post_meta( $post[ 'post_id' ], Social::get_field_id( 'url'), TRUE ) );
?>
<article data-type="social-embed">
  <?php echo wp_oembed_get( $url ); ?>
</article>
<?php
}

/**
 * Emit the markup to render one of the posts from Panel Builder's Post_List field as a Highlight
 *
 * @param array $post [ 'title', 'content', 'excerpt', 'image', 'link', 'post_type', 'post_id' ]
 */
function hs_render_social_post( $post ) {
  // first, get all the info we (might) need
  extract( $post ); // create variables $title, $content, $excerpt, $image, $link, $post_type, $post_id

  $url = trim( get_post_meta( $post_id, Social::get_field_id( 'url'), TRUE ) );
  if ( !empty( $url ) ) {
    $a_attrs = [
        'href'        => $url
      , 'aria-hidden' => 'true'
      , 'tabindex'    => '-1'
    ];
  } else {
    $a_attrs = [];
  }
?>
<article data-type="social-post">
<?php
  if ( isset( $image ) && is_numeric( $image ) && $image > 0 ) {
    hs_render_image( $image, [
        'show_caption' => FALSE
      , 'show_credit'  => FALSE
      , 'fixed_ar'     => FALSE // it is fixed_ar, but the ar is forced in the css for the posts panel
      , 'pic_attrs'    => [
            'data-anchor-v' => !empty( $img_anchor_v ) ? $img_anchor_v : 'center'
          , 'data-anchor-h' => !empty( $img_anchor_h ) ? $img_anchor_h : 'center'
        ]
      , 'a_attrs'      => $a_attrs
      , 'img_attrs'    => [
            'role'        => 'presentation'
        ]
    ] );
  }
?>
  <div class="content">
    <?php echo "    {$content}\n"; ?>
    <?php echo "    " . _hs_get_social_icon( $url ). "\n"; ?>
  </div>
</article>
<?php
}

/**
 * @param string $url full url of a post on a social platform
 *
 * @return string HTML with the correct icon for the url, linked to $url
 */
function _hs_get_social_icon( $url ) {
  // first, figure out what platform the url is on
  $host = parse_url( $url, PHP_URL_HOST ); // get the host component of the url
  $bits = explode( '.', $host ); // split the url's host into bits
  array_pop( $bits ); // lose the '.com'
  $platform = array_pop( $bits ); // get the actual host (facebook, twitter, instagram, ...)

  // get the right icon for the platform
  switch ( $platform ) {
    case 'facebook':
      $icon = "fa-facebook-square";
      break;
    case 'twitter':
    case 'instagram':
      $icon = "fa-{$platform}";
      break;
    default:
      break;
  }

  // now build the html
  $platform = ucfirst( $platform ); // capitalize the platform
  $html = <<<EOICON
<p><a href="{$url}" title="View post on {$platform}"><span class="fa {$icon}" aria-hidden="true"></span><span class="sr-only-text">View post on {$platform}</span></a></p>
EOICON;

  return $html;
}

/**
 * Fetch the events that are meant to appear on the homepage
 *
 * @param array $panel_vars
 *
 * @return array of events; each event is [ 'title', 'date', 'time', 'utcDate', 'location', 'image', 'url', 'tag' ]
 */
function hs_fetch_events( $panel_vars ) {
  $events = get_transient( HS_EVENT_TRANSIENT );

  if ( $events === FALSE ) {
    $events = [];
    libxml_use_internal_errors( TRUE );
    $feed = simplexml_load_file( $panel_vars[ 'feed_url' ] );
    if ( $feed === FALSE ) {
      echo "\n\n<!-- ERROR: Failed to load {$panel_vars[ 'feed_url' ]}\n";
      foreach ( libxml_get_errors() as $error ) {
        echo "            {$error->message}\n";
      }
      echo "-->\n\n";
    } else {
      foreach ( $feed->Event as $event ) {
        foreach ( $event as $item => $value ) {
          $ev[ $item ] = "{$value}"; // force SimpleXMLElements to strings
        }
        $events[] = $ev;
      }
    }
    set_transient( HS_EVENT_TRANSIENT, $events, $panel_vars[ 'cache_duration' ] * 60 );
  }

  return array_slice( $events, 0, $panel_vars[ 'num_posts' ] );
}

/**
 * Emit the search form
 *
 * @param string $domain 'web' | 'people' - which domain is selected by default
 * @param string $term initial value for the search field
 * @param string $id_prefix prefix to add to all id's to make them unique on the page
 */
function hs_search_form( $domain = "web", $term = '', $id_prefix = '' ) {
  $texts = [
      'web' => [
          'btnText'     => '<i class="fa fa-globe"></i>&nbsp;Search Web'
        , 'placeholder' => html_entity_decode('&#xf002;&nbsp;&nbsp;&nbsp; Search Stanford websites' )
      ]
    , 'people' => [
          'btnText'     => '<i class="fa fa-users"></i>&nbsp;Search people'
        , 'placeholder' =>  html_entity_decode( '&#xf002;&nbsp;&nbsp;&nbsp; Search by name, SUNet, email&hellip;' )
      ]
  ];
  $id = [
      'form'   => "{$id_prefix}search-form"
    , 'field'  => "{$id_prefix}search-field"
    , 'type'   => "{$id_prefix}search-type"
    , 'web'    => "{$id_prefix}search-web"
    , 'people' => "{$id_prefix}search-people"
    , 'button' => "{$id_prefix}search-btn"
  ]
  ?>

  <form action="<?php echo esc_url(home_url('/search')); ?>" method="get" id="<?php echo $id[ 'form' ]; ?>" accept-charset="UTF-8">
    <label for="<?php echo $id[ 'field' ]; ?>" class="sr-only-text">Search term</label>
    <input id="<?php echo $id[ 'field' ]; ?>" type="text" name="q" title="Search string" class="input-medium" placeholder="<?php echo $texts[ $domain ][ 'placeholder' ]; ?>" value="<?php echo esc_attr( $term ); ?>" size="15" maxlength="128" />
    <div id="<?php echo $id[ 'type' ]; ?>">
      <h2>Search Stanford:</h2>
      <input id="<?php echo $id[ 'web' ]; ?>" name="search_type" type="radio" value="web" <?php if ( $domain === 'web') { ?> checked="checked" <?php } ?> class="radio-search"/>
      <label for="<?php echo $id[ 'web' ]; ?>">Web</label>
      <input id="<?php echo $id[ 'people' ]; ?>" name="search_type" type="radio" value="people" <?php if ( $domain === 'people') { ?> checked="checked" <?php } ?> class="radio-search"/>
      <label for="<?php echo $id[ 'people' ]; ?>">People</label>
    </div>
    <button id="<?php echo $id[ 'button' ]; ?>" type="submit" name="submit" aria-label="Search" formmethod="get"><?php echo $texts[ $domain ][ 'btnText' ]; ?></button>
  </form>
<?php
  }

/**
 * Display weather information
 */
function hs_weather() {
  // if the Awesome Weather Widget Pro plugin is activated, use that
  if ( function_exists( 'awesome_weather_shortcode' ) ) {
    echo awesome_weather_shortcode ( [
        'location'            => 'Stanford, CA'
//	    , 'woeid'               => '2498941' // Yahoo Weather -- disabled
	    , 'owm_city_id'               => '5398563' //Open Weather Map
//        , 'zmw'               => '94305.1.99999' // Wunderground -- disabled
      , 'units'               => 'F'
      , 'forecast_days'       => 'hide'
      , 'show_icons'          => '1'
      , 'size'                => 'custom'
      , 'custom_template_name'=> 'weather-widget'
    ] );
  }
}

/**
 * Render an icon link to a social channel, and corresponding screen reader text.
 * Used in the "pre-footer".
 *
 * @param $channel one of: Facebook, Twitter, Instagram, YouTube, iTunes U, LinkedIn
 * @param $icon Font Awesome icon to display
 */
function hs_social_icon( $channel, $icon ) {
  $channels = [
      'Facebook'  => 'https://www.facebook.com/stanford'
    , 'Twitter'   => 'https://twitter.com/stanford'
    , 'Instagram' => 'https://www.instagram.com/stanford/'
    , 'YouTube'   => 'https://www.youtube.com/stanford'
    , 'iTunes U'  => 'https://podcasts.apple.com/us/artist/stanford/1280771285'
    , 'LinkedIn'  => 'https://www.linkedin.com/school/stanford-university/'
  ];
?>
  <li><a title="<?php echo $channel; ?>" class="xsu-link" data-ga-label="<?php echo $channel; ?>" href="<?php echo $channels[ $channel ]; ?>"><span class="fa <?php echo $icon; ?>" aria-hidden="true"></span><span class="sr-only-text"><?php echo $channel; ?></span></a></li>
<?php
}

/**
 * Get an array of filters to emit for the current list of websites. To filter by
 * letter of the alphabet, don't pass a parameter (or pass 'a-z'). To filter by
 * terms in the Lists taxonomy, pass an array of WP_Term's, which are the child
 * terms of the list that's being rendered.
 *
 * @param array | string $terms either an array of WP_Term's, or the string 'a-z'
 *
 * @return array of 'slug' => 'Display Name'
 */
function hs_get_filters( $terms = 'a-z' ) {
  $filters = [];
  if ( $terms == 'a-z' ) {
    foreach ( range( 'a', 'z' ) as $letter ) {
      $filters[ $letter ] = strtoupper( $letter );
    }
  } elseif ( is_array( $terms ) ) {
    // $terms should be an (possibly empty) array of WP_Term's
    foreach ( $terms as $term ) {
      $filters[ $term->slug ] = $term->name;
    }
  }
  return $filters;
}

/**
 * If $filters is not empty, emit the markup for the links used to filter a website list
 *
 * @param array $filters 'slug' => 'Display Name'
 */
function hs_maybe_emit_filters( $filters ) {
  if ( empty( $filters ) ) return;

  $filter_fmt = <<<FILTER_FMT
  <li>
    <a href="#%1\$s" class="show-tag%4\$s" data-filter="%1\$s" alt="show %2\$s" data-ga-action="%2\$s">%2\$s<span class="sr-only-text"> - %3\$s</span></a>
  </li>

FILTER_FMT;
?>
<ul id="list-filters" data-ga-category="List filters" aria-label="Filter list of websites">
<?php
  printf( $filter_fmt, 'all', 'All', 'Tab selected', ' current' );
  foreach ( $filters as $slug => $name ) {
    printf( $filter_fmt, $slug, $name, 'Tab', '' );
  }
?>
</ul>
<?php
}

/**
 * On listing pages, websites are grouped alphabetically. This function emits
 * the markup to open a new letter group, if necessary.
 *
 * @param  string $last_alpha first letter of the title of the last item emitted - pass '' for the first item
 * @return string first letter of the title of the current item
 */
function hs_maybe_start_new_letter( $last_alpha ) {
  $title = get_the_title();
  $alpha = strtolower( substr( $title, 0, 1 ) );
  if ( $alpha != $last_alpha ) {
    if ( !empty( $last_alpha ) ) {
      hs_end_letter();
    }
    echo "<div class=\"alpha-group\" data-filter=\"{$alpha}\">\n";
    echo "  <h3>{$alpha}</h3>\n";
    echo "  <ul>\n";
    $last_alpha = $alpha;
  }
  return $last_alpha;
}

/**
 * On listing pages, websites are grouped alphabetically. This function emits
 * the markup to end a letter group.
 */
function hs_end_letter() {
  echo "  </ul>\n";
  echo "</div>\n\n";
}

/**
 * Emit the footer for list pages, which contains the link to let us know about changes
 */
function hs_list_page_footer() {
?>

  <footer>
    <?php echo hs_shortcode_feedback_link( [], '' ); ?>
  </footer>

<?php
}


/******************************************************************************
 *  Helper functions
 */

/**
 * Change where an <a> tag links to
 *
 * @param string $a_tag an <a> tag with an href attribute
 * @param string $url the url you want the <a> tag to link to instead
 *
 * @return string the <a> tag with the updated hreff attribute
 */
function _hs_replace_href( $a_tag, $url ) {
  if ( !empty( $url ) ) {
    $url   = esc_attr( $url );
    $a_tag = preg_replace( '/href=(["\'])(.*?)(\\1)/', "href=\$1{$url}\$1", $a_tag );
  }
  return $a_tag;
}

/**
 * Return useful info about an image.
 * uri, width and height are esc_attr()'ed and ready to be included in attributes on the &lt;img&gt; tag.
 *
 * @param int $img_id - required
 * @param string $size - one of the supported sizes; defaults to original size
 * @return array [ 'uri', 'width', 'height', 'srcset', 'caption', 'credit', 'raw-credit', 'alt' ]
 */
function _hs_get_image_data( $img_id, $size = NULL ) {
  if ( empty( $img_id ) || !is_numeric( $img_id ) ) return []; // if there's no id, there's nothing to do

  $img_src  = wp_get_attachment_image_src( $img_id, $size );
  $img_post = get_post( $img_id );
  $caption  = trim( $img_post->post_excerpt );
  $img_data = [
      'id'         => $img_id
    , 'uri'        => esc_attr( $img_src[0] )
    , 'width'      => esc_attr( $img_src[1] )
    , 'height'     => esc_attr( $img_src[2] )
    , 'srcset'     => wp_get_attachment_image_srcset( $img_id, $size )
    , 'caption'    => $caption
    , 'credit'     => _hs_get_media_credit( $img_id, !empty( $caption ) )
    , 'raw-credit' => _hs_get_raw_media_credit( $img_id )
    , 'alt'        => esc_attr( get_post_meta( $img_id, '_wp_attachment_image_alt', true) )
  ];

  return $img_data;
}

/**
 * Return markup for media credit
 *
 * @param int     $img_id   - media post to get the credit from
 * @param boolean $appended - TRUE if credit will be appended to a caption (if TRUE, put parens around credit)
 * @return string - HTML for media credit
 */
function _hs_get_media_credit( $img_id, $appended = NULL ) {
  $credit = _hs_get_raw_media_credit( $img_id );
  if ( empty( $credit ) ) {
    return '';
  }

  $credit_prefix = "<span class=\"media-credit\">";
  $credit_suffix = "</span>";

  // if there's a caption, put the credit in parens
  if ( $appended ) {
    $credit_prefix = $credit_prefix . " (";
    $credit_suffix = ")" . $credit_suffix;
  }
  $credit_prefix .= __( "Image credit: ", 'stanford-text-domain' );

  return $credit_prefix . $credit . $credit_suffix;
}

/**
 * Return the media credit as stored in the DB, with no (additional) markup
 *
 * @param int $img_id
 * @return string
 */
function _hs_get_raw_media_credit( $img_id ) {
  return \Stanford\Homesite\Media_Metadata::get_media_credit( $img_id );
}

/**
 * Generate the <source> tag(s) for <picture> elements when there may be different images for
 * landscape and portrait orientations.
 *
 * @param int | string $landscape_srcset numeric id of image, or the image's srcset
 * @param int | string $portrait_srcset  numeric id of image, or the image's srcset
 *
 * @return <source> tag(s) for the <picture> element
 */
function _hs_picture_source_lp( $landscape_srcset, $portrait_srcset = "" ) {
  // if we're given id's, get the srcset's
  if ( is_numeric( $landscape_srcset ) ) $landscape_srcset = wp_get_attachment_image_srcset( $landscape_srcset );
  if ( is_numeric( $portrait_srcset  ) ) $portrait_srcset  = wp_get_attachment_image_srcset( $portrait_srcset  );

  // if there is no portrait srcset, or if they're the same, just use the landscape srcset
  if ( empty( $portrait_srcset ) || $portrait_srcset == $landscape_srcset ) {
    return "  <source srcset=\"{$landscape_srcset}\" />\n";
  } else {
    $source  = "  <source srcset=\"{$landscape_srcset}\" media=\"(orientation: landscape)\" />\n";
    $source .= "  <source srcset=\"{$portrait_srcset}\"  media=\"(orientation: portrait)\" />\n";
    return $source;
  }

  return ""; // shouldn't ever get here, but just in case
}

/**
 * Generate the <source> tag(s) for <picture> elements when there may be different images for
 * small and large devices.
 *
 * @param int | string $lg_srcset numeric id of image, or the image's srcset
 * @param int | string $sm_srcset numeric id of image, or the image's srcset
 *
 * @return <source> tag(s) for the <picture> element
 */
function _hs_picture_source( $lg_srcset, $sm_srcset = "" ) {
  // if we're given id's, get the srcset
  if ( is_numeric( $lg_srcset ) ) $lg_srcset = wp_get_attachment_image_srcset( $lg_srcset );
  if ( is_numeric( $sm_srcset ) ) $sm_srcset = wp_get_attachment_image_srcset( $sm_srcset );

  // if there is no small srcset, or if they're the same, just use the large srcset
  if ( empty( $sm_srcset ) || $lg_srcset == $sm_srcset ) {
    return "  <source srcset=\"{$lg_srcset}\" />\n";
  }

  // we need separate <source> tags for large and small images
  $source_fmt = '  <source srcset="%1$s" media="(%2$s-width: %3$dpx)" />' . "\n";
  $source  = "";

  // for widths at or below our cutoff, use the the small image
  $sm_imgs = _hs_parse_srcset( $sm_srcset );
  $srcset  = "";
  foreach ( $sm_imgs as $max_width => $url ) {
    if ( $max_width > HS_LG_IMG_MIN_WIDTH ) break;
    $srcset .= ( empty($srcset) ? "" : ", " ) . "{$url} {$max_width}w";
    $cutoff  = $max_width; // remember the width of the largest small image
  }
  if ( !empty( $srcset ) ) {
    $source .= sprintf( $source_fmt, $srcset, 'max', $cutoff );
  }

  // for widths larger than our largest small image, use the the large image
  $lg_imgs = _hs_parse_srcset( $lg_srcset );
  $srcset  = "";
  foreach ( $lg_imgs as $max_width => $url ) {
    if ( $max_width <= $cutoff ) continue;
    $srcset .= ( empty($srcset) ? "" : ", " ) . "{$url} {$max_width}w";
  }
  if ( !empty( $srcset ) ) {
    $source .= sprintf( $source_fmt, $srcset, 'min', $cutoff + 1 );
  }

  return $source;
}

/**
 * Split a srcset attribute for an image into an array of width => url. The array
 * will be sorted so the widths are increasing.
 *
 * @param string $srcset
 * @return array sorted array of width => 'image url'
 */
function _hs_parse_srcset( $srcset ) {
  $parsed = [];
  $imgs   = explode( ', ', $srcset );
  foreach ( $imgs as $img ) {
    $matches = [];
    if ( preg_match( '/(.*)\\s+(\\d+)w$/', $img, $matches ) ) {
      $parsed[ $matches[ 2 ] ] = $matches[ 1 ];
    }
  }
  ksort( $parsed );
  return $parsed;
}

/**
 * Given an array of attribute => value, return a single string suitable to be emitted
 * as attributes of an HTML element.
 *
 * @param  array  $attrs 'attribute' => 'value'
 * @return string
 */
function _hs_build_attrs( $attrs ) {
  $attributes = '';
  foreach ( $attrs as $attr => $value ) {
    if ( $value === NULL ) {
      $attributes .= " {$attr}";
    } else {
      if ( is_array( $value ) ) $value = implode( ' ', $value );
      $attributes .= " {$attr}=\"" . esc_attr( $value ) . "\"";
    }
  }
  return trim( $attributes );
}

/**
 * If the panel_builder plugin has been erroneously disabled, the whole site shouldn't fall over
 */
if ( !function_exists( 'have_panels' ) ) {
function have_panels() {
  return FALSE;
}
}


/******************************************************************************
 *  Template tags from underscores starter theme
 *  TODO: review and decide to keep or delete
 */

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function homesite17_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'homesite17' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'homesite17' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function homesite17_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'homesite17' ) );
		if ( $categories_list && homesite17_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'homesite17' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'homesite17' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'homesite17' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'homesite17' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'homesite17' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function homesite17_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'homesite17_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'homesite17_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so homesite17_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so homesite17_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in homesite17_categorized_blog.
 */
function homesite17_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	delete_transient( 'homesite17_categories' );
}
add_action( 'edit_category', 'homesite17_category_transient_flusher' );
add_action( 'save_post',     'homesite17_category_transient_flusher' );
