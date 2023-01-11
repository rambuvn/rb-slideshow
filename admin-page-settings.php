<?php
if ( !defined('ABSPATH') ) {
    die('Get out please');
}

$slideshow_images = get_option('_rb_slideshow_images', '');
?>

<div class="wrap rb-slideshow-settings">
    <h1><?php echo get_admin_page_title(  ); ?></h1>

    <form action="options.php" method="post" novalidate>
        <?php settings_fields( 'rb-rtcamp-settings-group' ); ?>
        <?php do_settings_sections( 'rb-rtcamp-settings-group' ); ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="rb-slideshow-images">Slideshow images</label>
                    </th>
                    <td>
                        <input type="hidden" name="_rb_slideshow_images" id="rb-slideshow-images" value="<?php echo $slideshow_images ?>">
                        <?php 
                            $attachments = explode(',',$slideshow_images);
                        ?>
                        <ul id="rb-slideshow-images-select" class="rb-sortable">
                            <?php if ( count($attachments) > 0 ) : ?>
                                <?php foreach( $attachments as $attachment_id ) : ?>
                                    <?php $image_url = wp_get_attachment_url($attachment_id); ?>
                                    <li class="item" data-attachment-id="<?php echo $attachment_id; ?>">
                                        <img src="<?php echo $image_url; ?>" alt="<?php echo get_the_title( $attachment_id ); ?>">
                                        <div class="item--remove">x</div>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <li class="button">&plus;</li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>