<?php
$panel_vars = get_panel_vars();
$url       = esc_attr( $panel_vars['link']['url']   );
$text      = $panel_vars['link']['label'];
$ga_action = esc_attr( $text );
?>

<a href="<?php echo $url; ?>" data-ga-category="Call to action" data-ga-action="<?php echo $ga_action; ?>"><?php echo $text; ?></a>
