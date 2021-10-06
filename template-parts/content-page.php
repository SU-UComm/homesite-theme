<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package homesite-2017
 */

$content = trim( get_the_content() );
?>

	<header>
		<?php the_title( "<h1>", "</h1>\n" ); ?>
	</header><!-- .entry-header -->

  <?php if ( !empty( $content ) ) { ?>
	<section class="entry-content">
		<?php the_content(); ?>
	</section><!-- .entry-content -->
  <?php } ?>

  <?php hs_render_panels( 'main' ); ?>

