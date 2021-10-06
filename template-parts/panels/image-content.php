<?php
$panel_vars = get_panel_vars();

$content       = apply_filters( 'the_content', $panel_vars[ 'content' ] );
$content_first = $panel_vars[ 'img_loc' ] == 'right';

hs_panel_header( $panel_vars );

echo "<section>\n";

if (  $content_first ) echo "<div class='content'>\n{$content}\n</div>\n";

hs_render_image( $panel_vars[ 'img' ], [
    'show_caption' => $panel_vars[ 'show_caption' ] != 'no'
  , 'show_credit'  => $panel_vars[ 'show_credit'  ] != 'no'
  , 'fixed_ar'     => FALSE // the image is fixed ar, but the ar is forced to 3:2 in the css for this panel
] );

if ( !$content_first ) echo "<div class='content'>\n{$content}\n</div>\n";

echo "</section>\n";

?>
