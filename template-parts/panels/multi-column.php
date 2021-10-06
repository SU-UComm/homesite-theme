<?php
$panel_vars = get_panel_vars();

hs_panel_header( $panel_vars );
?>
<div class="grid-container">
<?php

foreach ( $panel_vars[ 'columns' ] as $column ) {
  echo "  <section>\n    ";
  echo apply_filters( 'the_content', $column[ 'content' ] );
  echo "  </section>\n";
}

?>
</div>
<?php

hs_panel_footer( $panel_vars );

?>
