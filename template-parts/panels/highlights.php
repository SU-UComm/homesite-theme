<?php
$panel_vars = get_panel_vars();

hs_panel_header( $panel_vars );
?>
<div class="grid-container">
<?php

foreach ( $panel_vars[ 'the_highlights' ] as $highlight ) {
  hs_render_highlight( $highlight );
}

?>
</div>
<?php

hs_panel_footer( $panel_vars );

?>
