<?php
/**
 * Front-end display of shortcode
 *
 * @package rtCamp
 */

if ( ! defined('ABSPATH') ) {
	die('Get out please');
}

$slideshow_images = get_option('_rb_slideshow_images', '');
$attachtments = explode(',', $slideshow_images);


if ( count($attachtments) > 0 ) {
	?>
	<div class="owl-carousel">
	<?php foreach( $attachtments as $attachment_id ) :
		$image_url = wp_get_attachment_url(intval($attachment_id));
		if ( ! $image_url ) {
			continue;
		}
		$caption = wp_get_attachment_caption($attachment_id);
		if ( ! $caption ) {
			$caption = get_the_title($attachment_id);
		}
		?>
		<div><img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_html($caption); ?>"></div>
	<?php endforeach; ?>
	</div>
	<?php
}
