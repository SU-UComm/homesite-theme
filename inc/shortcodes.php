<?php
/**
 * Custom shortcodes for this theme.
 *
 * @package homesite-2017
 */


/******************************************************************************
 *  Stanford shortcodes - all function names start with hs_ (for homesite)
 */

/**
 * Build the markup for the [caption] shortcode. Replaces default functionality.
 * Invoked via the img_caption_shortcode filter.
 *
 * @param  string $unused  The caption output. Default empty.
 * @param  array  $attr    Attributes of the caption shortcode.
 * @param  string $content The image element, possibly wrapped in a hyperlink.
 * @return string full HTML markup to replace the [caption] shortcode
 */
function hs_shortcode_caption($unused, $attr, $content) {
  $atts = shortcode_atts( array(
      'id'       => NULL,
      'align'    => 'alignright',
      'width'    => 'wide',
      'caption'  => '',
      'class'    => '',
      'nocredit' => FALSE
  ), $attr, 'caption' );

  if ( empty($atts['id'] ) ) return "<!-- ERROR: [caption] shortcode: no id specified -->";

  // get the numeric id from text 'attachment_9999' (why don't they just pass the numeric id???)
  $matches = array();
  $id = preg_match('/\\d+$/', $atts[ 'id' ], $matches) ? $matches[0] : NULL;
  if ( empty( $id ) ) return "<!-- ERROR: [caption] shortcode: unable to determine id from {$atts[ 'id' ]} -->";

  // clean up the caption text
  $caption = trim( str_replace('NO_CAPTION', '', $atts['caption']) ); // strip string added to images with no caption to force this shortcode

  // if the image is linked, find the url and pass it along
  $matches = [];
  if ( preg_match( '/<a .*?href=([\'"])(.*?)\\1/', $content, $matches ) ) {
    $link = [ 'href' => $matches[ 2 ] ];
  } else {
    $link = [];
  }

  $html = hs_render_image( $id, [
      'show_caption' => $caption
    , 'show_credit'  => !$atts[ 'nocredit' ]
    , 'fixed_ar'     => FALSE
    , 'fig_attrs'    => [ 'class' => str_replace( 'alignnone', 'alignwide', $atts[ 'align' ] ) ]
    , 'a_attrs'      => $link
    , 'echo'         => FALSE
  ] );

  return $html;
}

/**
 * [flex-grid]...[/flex-grid] shortcode
 * Render $content in CSS flex box container
 *
 * @param array $atts
 *              columns  => 2 | 3 | 4 | 5 | 6 - number of columns to render in the container
 *              align    => start | end | center | stretch | baseline - default 'stretch'
 * @param string $content - content to be displayed in the flex container
 *
 * @return string html
 */
function hs_shortcode_flex_grid( $atts, $content ) {
  $atts = shortcode_atts( [
      'columns' => '2'
    , 'align'   => 'start'
  ], $atts );

  // if no content, return nothing
  if ( empty( trim( $content ) ) ) return '';

  $attrs = [ 'class' => 'flex-grid' ];
  foreach ( $atts as $attr => $value ) {
    $attrs[ "data-{$attr}" ] = $value;
  }

  add_shortcode( 'flex-item', 'hs_shortcode_flex_item' );
  $html  = "<div " . _hs_build_attrs( $attrs ) . ">\n";
  $html .= apply_filters( 'the_content', $content ) . "\n";
  $html .= "</div>\n\n";
  remove_shortcode( 'flex-item' );

  return $html;
}

/**
 * [flex-item]...[/flex-item] shortcode
 * Render $content as an item in a flex box container.
 * Must be contained within the content of a [flex-grid] shortcode.
 *
 * @param array $atts
 *              align => start | end | center | stretch | baseline - default 'stretch'
 *              width => min | default | full
 * @param string $content - content to be displayed in the flex container
 *
 * @return string html
 */
function hs_shortcode_flex_item( $atts, $content ) {
  shortcode_atts( [
      'align' => NULL
    , 'width' => NULL
  ], $atts );

  $attrs = [ 'class' => 'flex-item' ];
  if ( !empty( $atts ) ) {
    foreach ( $atts as $attr => $value ) {
      if ( !empty( $value ) ) $attrs[ "data-{$attr}" ] = $value;
    }
  }

  $html  = "<div " . _hs_build_attrs( $attrs ) . ">\n";
  $html .= apply_filters( 'the_content', $content ) . "\n";
  $html .= "</div>\n\n";

  return $html;
}

/**
 * [feedback-link] shortcode
 *
 * @param array $atts
 *              url   => url of feedback form
 *              label => label for link to feedback borm
 * @param string $content text to precede link to feedback form
 *
 * @return string html
 */
function hs_shortcode_feedback_link( $atts, $content ) {
  $atts = shortcode_atts( [
      'url'   => 'https://stanford.service-now.com/services?id=get_help&cmdb_ci=915f10561329474019813598d144b00f'
    , 'label' => 'Let us know!'
  ], $atts );

  $text = !empty( $content ) ? $content : 'Know of a link we should add, change or delete?';
  if ( strpos( $text, '<a ' ) === FALSE ) {
    $text .= " <a href=\"{$atts[ 'url' ]}\">{$atts[ 'label' ]}</a>";
  }

  $attrs = _hs_build_attrs( [
      'class'            => "feedback-link"
    , 'data-ga-category' => "Feedback"
    , 'data-ga-action'   => "Report change"
  ] );
  $html = "<p {$attrs}>{$text}</p>";

  return $html;
}

/**
 * [info-box]...[/info-box] shortcode
 * Render $content in an info box
 *
 * @param array $atts
 *              location => left | right | inline | inset
 *              color    => red | green | black
 *              title    => Full text of title
 *              icon     => full class name of Font Awesome icon, e.g. fa-home
 *              height   => auto | full (if 'full', add height: 100%)
 * @param string $content - text to be displayed in the info box
 *
 * @return string html
 */
function hs_shortcode_info_box( $atts, $content ) {
  extract( shortcode_atts( [
      'location' => 'inline'
    , 'color'    => 'red'
    , 'title'    => ''
    , 'icon'     => ''
    , 'height'   => 'auto'
  ], $atts ) ); // create variables $location, $color, $title, $icon

  // if no content, return nothing
  if ( empty( trim( $content ) ) ) return '';

  // get the icon
  if ( !empty( $icon  ) ) {
    // if this isn't a block level element, wpautop() will put an unmatched </p> tag after
    // it, resulting in invalid markup and incorrect spacing :(
    $icon = "<div class='fa " . sanitize_text_field( $icon ) . " center' aria-hidden='true'></div>";
  };

  // if the title is specified as attributes, build the title
  $title = sanitize_text_field( trim( $title ) );
  if ( !empty( $title ) ) {
    $title = "<h3>{$title}</h3>\n";
  }

  // tidy up the content and apply content filters
  $content = _hs_clean_content( $content, TRUE );

  // determine attributes for the <aside>
  $locations = [
      'inset' => 'inset'
    , 'left'  => 'alignleft'
    , 'right' => 'alignright'
  ]; // inline is the default
  $colors = [
      'green'
    , 'blue'
    , 'black'
  ]; // red is the default

  $attrs = [
      'class' => 'info-box'
  ];
  if ( isset( $locations[ $location ] ) ) $attrs[ 'class' ]      .= " {$locations[ $location ]}";
  if ( $height != 'auto'                ) $attrs[ 'data-height' ] = esc_attr( $height );
  if ( in_array( $color, $colors )      ) $attrs[ 'data-color'  ] = $color; // 'red' is the default
  $attributes = _hs_build_attrs( $attrs );

  $html = <<<EOINFOBOX

  <div {$attributes}>
    {$icon}{$title}{$content}
  </div>

EOINFOBOX;

  return $html;
}

/**
 * [inline-links]...[/inline-links] shortcode
 * Render $content as inline link list separated by vertical bars
 *
 * @param array  $atts    'align' => 'left|center|right', 'size' => 'small|large'
 * @param string $content <ul>...</ul> list of links
 * @return string <ul>...</ul> with appropriate classes and style attributes
 */
function hs_shortcode_inline_links( $atts, $content ) {
	extract( shortcode_atts( [
			'align' => 'center'
		, 'size'  => 'large'
	], $atts ) );

  // tidy up the content - do not apply content filters
  $content = _hs_clean_content( $content, FALSE );

  $align = in_array( $align, [ 'left', 'center', 'right' ] ) ? "style=\"text-align: {$align};\"" : "";
  $size  = in_array( $size,  [ 'small', 'large' ] ) ? "{$size}-text" : "";

	$content = str_replace( "<ul>", "<ul class=\"inline-links {$size}\" {$align}>", $content );
	return $content;
}

/**
 * [jump-link]...[/jump-link] shortcode
 * add class="jump-link" to the <a> tag, append the jump link icon to the anchor text
 *
 * @param array $atts if $atts[ 'url' ] is not empty, wrap $content in <a href="{$atts['url']}">...</a>; otherwise, $content should be an <a> element
 * @param string $content HTML markup containing the link (if no 'url') or anchor text (if 'url')
 *
 * @return string <a class="jump-link" ...>{$content}<span class="fa fa-angle-right" aria-hidden="true"></span></a></a>
 */
function hs_shortcode_jump_link( $atts, $content ) {
  extract( shortcode_atts( [
      'url' => '' // it may be easier to use TinyMCE to create the link in $content, vs. passing the url as an attribute
  ], $atts ) ); // create variable $url

  if ( !empty( $url ) ) {
    $content = "<a href=\"" . esc_attr( $url ) . "\">{$content}</a>";
  }

  $content = str_replace(
      [ '<a',                   '</a>' ]
    , [ '<a class="jump-link"', '<span class="fa fa-angle-right" aria-hidden="true"></span></a>' ]
    , $content
  );

  return "{$content}";
}

/**
 * [jump-links]...[/jump-links] shortcode
 * Render $content as a list of links styled like highlight / standalone linkes
 *
 * @param array $atts [ 'align' => "normal | center" ]
 * @param string $content <ul>...</ul> list of links
 * @return string <ul>...</ul> with appropriate classes and style attributes
 */
function hs_shortcode_jump_links( $atts, $content ) {
  // if no content, return nothing
  if ( empty( trim( $content ) ) ) return '';

  extract( shortcode_atts( [
      'align' => 'normal'
  ], $atts ) );

  // tidy up the content - do not apply content filters
  $content = _hs_clean_content( $content, FALSE );

  // find the <li>'s
  $matches = [];
  preg_match_all( ':<li.*?>(.*?)</li>:', $content, $matches );

  // for each <li>, apply the [jump-link] shortcode to it
  $jump_links = [];
  foreach ( $matches[ 1 ] as $link ) {
    $jump_links[] = hs_shortcode_jump_link( [], $link );
  }

  // replace the <li>'s with the corresponding jump links
  $content = str_replace( $matches[ 1 ], $jump_links, $content );

  // add the right class(es) to the <ul>
  $class   = ( $align == 'center' ) ? "jump-links center" : "jump-links";
  $content = str_replace( "<ul>", "<ul class=\"{$class}\">", $content );

	// all done
	return $content;
}

/**
 * [lead]...[/lead] shortcode
 * Render $content as lead paragraph
 *
 * @param array $atts [ 'align' => "normal | center" ]
 * @param string $content
 * @return string html
 */
function hs_shortcode_lead( $atts, $content ) {
  // if no content, return nothing
  if ( empty( trim( $content ) ) ) return '';

  extract( shortcode_atts( [
      'align' => 'normal'
  ], $atts ) );

  $class = ( $align == 'center' ) ? "lead center" : "lead";

  // tidy up the content and apply content filters
  $content = _hs_clean_content( $content, TRUE );

  return "<div class=\"{$class}\">{$content}</div>";
}

/**
 * [meta]...[/meta] shortcode
 * Render $content as meta information, e.g. date, category, ...
 *
 * @param array $atts [ 'align' => "normal | center"
 * @param string $content
 * @return string html
 */
function hs_shortcode_meta( $atts, $content ) {
  // if no content, return nothing
  if ( empty( trim( $content ) ) ) return '';

  extract( shortcode_atts( [
      'align' => 'normal'
  ], $atts ) );

  $class = ( $align == 'center' ) ? "post-meta center" : "post-meta";

  // tidy up the content and apply content filters
  $content = _hs_clean_content( $content, TRUE );

  return "<div class=\"{$class}\">{$content}</div>";
}

/**
 * [quick-link]...[/quick-link] shortcode
 * Render a "quick link" with an icon that links to the first href in $content, if any.
 *
 * @param array $atts - icon => full class name of Font Awesome icon, e.g. fa-home
 * @param string $content - text containing a link on the first line, and a brief description on the second line
 *
 * @return string html
 */
function hs_shortcode_quick_link( $atts, $content ) {
  // if no content, nothing to do
  if ( empty( trim( $content ) ) ) return '';

  extract( shortcode_atts( [
      'icon'     => ''
  ], $atts ) ); // create variable $icon


  // get the icon
  if ( !empty( $icon  ) ) {
    $icon_classes = "fa fa-2x " . esc_attr( $icon );
    // find the target of the first link in $content
    if ( preg_match( '/href=(["\'])(.*?)\\1/', $content, $matches ) ) {
      $href = $matches[ 2 ];
      $icon = "<div aria-hidden='true'><a href='{$href}' tabindex='-1'><span class='{$icon_classes}'></span></a></div>";
    } else {
      // use <div> instead of <span> - if this isn't a block level element, wpautop() will put
      // an unmatched </p> tag after it, resulting in invalid markup and incorrect spacing :(
      $icon = "<div class='{$icon_classes}' aria-hidden='true'></div>";
    }
  };

  $html = <<<EOQUICKLINK

  <div class="quick-link">
    {$icon}{$content}
  </div>
EOQUICKLINK;

  return $html;
}

/**
 * [vertical-links]...[/vertical-links] shortcode
 * Render $content as inline link list separated by vertical bars
 *
 * @param array  $atts - unused
 * @param string $content <ul>...</ul> list of links
 * @return string <ul>...</ul> with appropriate classes and style attributes
 */
function hs_shortcode_vertical_links( $atts, $content ) {
  // tidy up the content - do not apply content filters
  $content = _hs_clean_content( $content, FALSE );

  $content = str_replace( "<ul>", "<ul class=\"vertical-links\">", $content );
  return $content;
}


/******************************************************************************
 *  Add shortcodes
 */

add_shortcode( 'feedback-link',  'hs_shortcode_feedback_link' );
add_shortcode( 'flex-grid',      'hs_shortcode_flex_grid' );
add_shortcode( 'info-box',       'hs_shortcode_info_box' );
add_shortcode( 'inline-links',   'hs_shortcode_inline_links' );
add_shortcode( 'jump-link',      'hs_shortcode_jump_link' );
add_shortcode( 'jump-links',     'hs_shortcode_jump_links' );
add_shortcode( 'lead',           'hs_shortcode_lead' );
add_shortcode( 'meta',           'hs_shortcode_meta' );
add_shortcode( 'quick-link',     'hs_shortcode_quick_link' );
add_shortcode( 'vertical-links', 'hs_shortcode_vertical_links' );

// [caption] is a built-in WordPress shortcode - we need a couple of filters to override it
// this filter forces the [caption] shortcode to be inserted, even if there's no caption
add_filter( 'image_add_caption_text', function($caption, $id){ return empty($caption) ? "NO_CAPTION" : $caption; }, 5, 2);
// this filter short-circuits the built-in code by providing our own markup for images
add_filter( 'img_caption_shortcode', 'hs_shortcode_caption', 10, 3 );


/******************************************************************************
 *  Add help text
 */

/**
 * Add a tab to the Help panel on Create / Edit post pages describing what features are available
 * when you're editing a post.
 * Invoked via the load-post.php and load-post-new.php actions.
 *
 * @since 1.0.0
 */
function hs_help_shortcodes() {
  $shortcodes = [];

  $shortcodes[ 'caption' ]          = "[caption nocredit=\"1\" align=\"alignleft | aligncenter | alignnone | alignright\" id=\"attachment_id\"]caption[/caption]\n";
  $shortcodes[ 'caption' ]         .= "<p class=\"help-desc\">";
  $shortcodes[ 'caption' ]         .= __("Display an image with caption.<br/><code>aligncenter</code> centers the image and insets it; <code>alignnone</code> centers the image and outsets it.<br/>Alt text is retrieved from the media library.<br/>Image credit is automatically included. Use <code>nocredit=\"1\"</code> to suppress image credit.", 'stanford-text-domain');
  $shortcodes[ 'caption' ]         .= "</p>\n";

  $shortcodes[ 'feedback-link' ]    = "[feedback-link url=\"link to feedback form\" label=\"text for link to feedback form\"]text to precede link[/feedback-link]\n";
  $shortcodes[ 'feedback-link' ]   .= "<p class=\"help-desc\">";
  $shortcodes[ 'feedback-link' ]   .= __("Everything is optional. Defaults are:<br/><code>url</code> - link to open a SNOW ticket related Stanford's home page<br/><code>label</code> - 'Let us know!'<br/><code>content</code> - 'Know of something we should add, change or delete?'", 'stanford-text-domain');
  $shortcodes[ 'feedback-link' ]   .= "</p>\n";

  $shortcodes[ 'flex-grid' ]        = "[flex-grid columns=\"2 | 3 | 4 | 5 | 6\" align=\"start | end | center | stretch | baseline\"]content[/flex-grid]\n";
  $shortcodes[ 'flex-grid' ]       .= "<p class=\"help-desc\">";
  $shortcodes[ 'flex-grid' ]       .= __("Display content in a flex container. <code>columns</code> is the number of columns to render in the container. <code>align</code> defaults to 'stretch'.", 'stanford-text-domain');
  $shortcodes[ 'flex-grid' ]       .= "</p>\n";

  $shortcodes[ 'flex-item' ]        = "[flex-item align=\"start | end | center | stretch | baseline\" width=\"min | default | full\"]content[/flex-item]\n";
  $shortcodes[ 'flex-item' ]       .= "<p class=\"help-desc\">";
  $shortcodes[ 'flex-item' ]       .= __("Display content as a flex item. Must be contained within a <code>[flex-grid]</code> shortcode. <code>align</code> defaults to 'stretch'.<br/><strong>WARNING:</strong> For all <code>[flex-item]</code>'s but the first, you must put the opening <code>[flex-item]</code> tag on the same line as the previous closing <code>[/flex-item]</code> tag, with no intervening whitespace. If there is any intervening whitespace, WordPress will insert empty paragraphs that break the layout.", 'stanford-text-domain');
  $shortcodes[ 'flex-item' ]       .= "</p>\n";

  $shortcodes[ 'info-box' ]         = "[info-box location=\"left | right | inline | inset\" color=\"red | green | blue | black\" title=\"title\" icon=\"fa-icon\" height=\"auto | full\"]content[/info-box]\n";
  $shortcodes[ 'info-box' ]        .= "<p class=\"help-desc\">";
  $shortcodes[ 'info-box' ]        .= __("Display an info box. <code>icon</code> should be the full class name of a Font Awesome icon, e.g. <code>fa-info-circle</code>.", 'stanford-text-domain');
  $shortcodes[ 'info-box' ]        .= "</p>\n";

  $shortcodes[ 'vertical-links' ]   = "[vertical-links]...[/vertical-links]\n";
  $shortcodes[ 'vertical-links' ]  .= "<p class=\"help-desc\">";
  $shortcodes[ 'vertical-links' ]  .= __("Mostly useful for sidebars. The content should be a <code>&lt;ul&gt;</code> of links. The <code>&lt;li&gt;</code>'s will be rendered as a vertical list of links horizontal bars between them.", 'stanford-text-domain');
  $shortcodes[ 'vertical-links' ]  .= "</p>\n";

  $shortcodes[ 'inline-links' ]     = "[inline-links align=\"left | center | right\" size=\"small | large\"]...[/inline-links]\n";
  $shortcodes[ 'inline-links' ]    .= "<p class=\"help-desc\">";
  $shortcodes[ 'inline-links' ]    .= __("The content should be a <code>&lt;ul&gt;</code> of links. The <code>&lt;li&gt;</code>'s will be rendered inline, separated by vertical bars. On hover, the links will get the same animated underline as nav links.", 'stanford-text-domain');
  $shortcodes[ 'inline-links' ]    .= "</p>\n";

  $shortcodes[ 'jump-links' ]       = "[jump-links]...[/jump-links]\n";
  $shortcodes[ 'jump-links' ]      .= "<p class=\"help-desc\">";
  $shortcodes[ 'jump-links' ]      .= __("The content should be a <code>&lt;ul&gt;</code> of links. The <code>&lt;li&gt;</code>'s will be rendered as jump links, with the &gt; and hover animation.", 'stanford-text-domain');
  $shortcodes[ 'jump-links' ]      .= "</p>\n";

  $shortcodes[ 'jump-link' ]        = "[jump-link url=\"url\"]...[/jump-link]\n";
  $shortcodes[ 'jump-link' ]       .= "<p class=\"help-desc\">";
  $shortcodes[ 'jump-link' ]       .= __("If no <code>url</code> is specified, then the content should be a link; if <code>url</code> is specified, the content will be wrapped in a link pointing to <code>url</code>. The link will be rendered as a jump link, with the &gt; and hover animation.", 'stanford-text-domain');
  $shortcodes[ 'jump-link' ]       .= "</p>\n";

  $shortcodes[ 'lead' ]             = "[lead align=\"normal | center\"]...[/lead]\n";
  $shortcodes[ 'lead' ]            .= "<p class=\"help-desc\">";
  $shortcodes[ 'lead' ]            .= __("Display the enclosed text as a <strong>lead</strong> paragraph, i.e. in a larger, lighter-weight font. If <code>align=\"center\"</code> is specifed, also center the text.", 'stanford-text-domain');
  $shortcodes[ 'lead' ]            .= "</p>\n";

  $shortcodes[ 'meta' ]             = "[meta align=\"normal | center\"]...[/meta]\n";
  $shortcodes[ 'meta' ]            .= "<p class=\"help-desc\">";
  $shortcodes[ 'meta' ]            .= __("Display the enclosed text as <strong>meta</strong> text, e.g. date, category, .... If <code>align=\"center\"</code> is specifed, also center the text.", 'stanford-text-domain');
  $shortcodes[ 'meta' ]            .= "</p>\n";

  $shortcodes[ 'quick-link' ]       = "[quick-link icon=\"icon\"]...[/quick-link]\n";
  $shortcodes[ 'quick-link' ]      .= "<p class=\"help-desc\">";
  $shortcodes[ 'quick-link' ]      .= __("Display a quick link. Content should contain the link and a brief description on a separate line. <code>icon</code> should be the full class name of a Font Awesome icon, e.g. <code>fa-info-circle</code>.", 'stanford-text-domain');
  $shortcodes[ 'quick-link' ]      .= "</p>\n";

  // allow plugins to document the shortcodes they add
  $shortcodes = apply_filters( 'help_text_shortcodes', $shortcodes );

  if ( !empty( $shortcodes ) ) {
    // ksort( $shortcodes ); // sort by shortcode
    $help_text  = "\n<h2>The following shortcodes are available:</h2>\n";
    $help_text .= "<ul>\n  <li>" . implode( "  </li>\n  <li>\n", $shortcodes ) . "  </li>\n</ul>\n";

    $screen = get_current_screen();
    $screen->add_help_tab( array(
        'id'      => 'shortcodes'
      , 'title'   => __( 'Shortcodes', 'stanford-text-domain' )
      , 'content' => $help_text
    ));
  }

}
add_action( 'load-post.php',     'hs_help_shortcodes' );
add_action( 'load-post-new.php', 'hs_help_shortcodes' );


/******************************************************************************
 *  Utility functions
 */

/**
 * Clean up a shortcode's content:
 *     remove leading & trailing whitespace
 *     remove weird markup WordPress / TinyMCE might've injected
 *     optionally apply content filters
 *
 * @param string $content
 * @param bool   $filter_content if TRUE, apply content filters to $content
 *
 * @return mixed|string|void
 */
function _hs_clean_content( $content, $filter_content = TRUE ) {
  // remove leading and trailing whitespace
  $content = trim($content);

  // remove weird markup WordPress / TinyMCE might've injected
  $content = preg_replace( [
      ':^(</p>|<br\s*?/>)\s*:'   // remove unmatched </p> or <br /> at the beginning of the content
    , ':\s*(<p>|<br\s*?/>)\s*$:' // remove unmatched <p> or <br /> at the end of the content
  ], '', $content );

  // process the content like regular content
  if ( $filter_content ) {
    $content = apply_filters( 'the_content', $content );
  }

  return trim( $content );
}