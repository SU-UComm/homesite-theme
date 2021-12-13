<?php

$title       = get_panel_var( 'title' );
$widget_html = get_panel_var( 'localist_widget_html' );

$panel       = get_the_panel();
$panel_depth = $panel->get_depth();

?>
<?php if ( $title ) : ?>
  <?php if ( $panel_depth === 0 ) : ?>
    <header class="panel__header">
      <h2 class="panel__title panel__title--underline">
        <?php echo esc_html( $title ); ?>
      </h2>
    </header>
  <?php else : ?>
    <header class="panel__header">
      <h3 class="panel__title panel__title--underline">
        <?php echo esc_html( $title ); ?>
      </h3>
    </header>
  <?php endif; ?>
<?php endif; ?>
<div class="panel__content localist-widget">
  <?php echo $widget_html; ?>
</div>
