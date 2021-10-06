<?php
$panel_vars = get_panel_vars();

hs_panel_header( $panel_vars );

echo apply_filters( 'the_content', $panel_vars[ 'text' ] );

hs_panel_footer( $panel_vars );

?>
