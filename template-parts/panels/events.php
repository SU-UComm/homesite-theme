<?php
$panel_vars = get_panel_vars();

hs_panel_header( $panel_vars );

$events = hs_fetch_events( $panel_vars );
?>
<div class="grid-container">
<?php
foreach ( $events as $event ) {
  list( $month, $day ) = explode( ' ', $event[ 'date' ] );
?>
  <figure itemscope itemtype="http://schema.org/Event">
    <a href="<?php echo $event[ 'url' ]; ?>" class="img-wrapper" tabindex="-1" aria-hidden="true"><img src="<?php echo $event[ 'image' ]; ?>" alt="" role="presentation"></a>
    <div class="date" itemprop="startDate" content="<?php echo $event[ 'utcDate' ]; ?>">
      <span class="month"><?php echo $month; ?></span>
      <span class="day"><?php echo $day; ?></span>
    </div>
    <div class="content">
      <p class="tag"><?php echo $event[ 'tag' ]; ?></p>
      <h3 itemprop="name"><a href="<?php echo $event[ 'url' ]; ?>" itemprop="url"><?php echo $event[ 'title' ]; ?></a></h3>
      <time datetime="<?php echo $event[ 'utcDate' ]; ?>"><?php echo $event[ 'time' ]; ?></time>
    </div>
  </figure>
<?php
}
?>
</div>
<?php

hs_panel_footer( $panel_vars );

?>
