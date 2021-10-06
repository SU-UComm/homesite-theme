<?php
/**
 * Created by PhpStorm.
 * User: stocker
 * Date: 4/24/17
 * Time: 1:15 PM
 */

awe_change_weather_form($weather); ?>

<?php if (isset($weather->data['current'])) { ?>

	<span class="awesome-weather-icon">
		<?php if ($weather->show_icons) { ?><i class="<?php echo $weather->data['current']['icon']; ?>" aria-label="<?php echo $weather->data['current']['description']; ?>" title="<?php echo $weather->data['current']['description']; ?>"></i><?php } ?>
	</span>
	<span class="awesome-weather-current-temp">
		<?php echo $weather->data['current']['temp']; ?><sup>&deg;</sup> F / <?php echo awe_f_to_c( $weather->data['current']['temp'] ); ?><sup>&deg;</sup> C
	</span><!-- /.awesome-weather-current-temp -->
	<span class="awesome-weather-description">
		<?php echo $weather->data['current']['description']; ?>
	</span>
<?php } ?>

<?php awe_extended_link($weather); ?>
<!-- /.awesome-weather-wrap: custom -->