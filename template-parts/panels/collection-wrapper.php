<?php

/**
 * A customized view for rendering a collection of modular panels.
 * 
 * IMPORTANT: the data attribute is REQUIRED for the live preview iframe to function. 
 *
 * @var string $panels The rendered HTML of the panels
 */

if ( !empty( trim( $panels ) ) ) {
?>

<section class="panel-collection" data-modular-content-collection>

	<?php echo $panels; ?>

</section><!-- panel-collection -->

<?php } ?>