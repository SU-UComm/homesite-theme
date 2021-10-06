<?php
$panel_vars = get_panel_vars();

hs_panel_header( $panel_vars );

$panel    = get_the_panel();
$children = $panel->get_children();
foreach ( $children as $child ) {
  echo $child->render();
}