<?php
$panel_vars = get_panel_vars();


hs_panel_header( $panel_vars );

?>

<div class="content">
<?php echo apply_filters( 'the_content', $panel_vars[ 'content' ] ); ?>
</div>

<?php

hs_panel_footer( $panel_vars );