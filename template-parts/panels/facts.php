<?php
$panel_vars = get_panel_vars();

hs_panel_header( $panel_vars );

if ( $panel_vars[ 'show_top_rule' ] == 'yes') echo "<hr aria-hidden='true'/>\n";
?>
<div class="grid-container">
<?php
foreach ( $panel_vars[ 'the_facts' ] as $fact ) {
  $fmt = ( $fact[ 'bold' ] == 'line1' ) ? "<strong>%s</strong> %s\n" : "%s <strong>%s</strong>\n";
?>
  <figure>
    <?php printf( $fmt, $fact[ 'line1' ], $fact[ 'line2' ] ); ?>
  </figure>
<?php
}
?>
</div>
<?php
if ( $panel_vars[ 'show_bottom_rule' ] == 'yes') echo "<hr aria-hidden='true'/>\n";
?>
