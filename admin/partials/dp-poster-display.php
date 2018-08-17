<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://devtey.com/
 * @since      1.0.0
 *
 * @package    Devtey_Poster
 * @subpackage Devtey_Poster/admin/partials
 */
?>
<div class="dp-container">
    <h2 class="devtey-title">Wallpaper Uploader</h2>
    <hr>
    <?php
    session_unset(); // unset all session
    if (!current_user_can('upload_files'))
        wp_die(__('Sorry, you are not allowed to upload files.'));
            
    wp_enqueue_script('plupload-handlers');

    $post_id = 0;
    if ( isset( $_REQUEST['post_id'] ) ) {
        $post_id = absint( $_REQUEST['post_id'] );
        if ( ! get_post( $post_id ) || ! current_user_can( 'edit_post', $post_id ) )
            $post_id = 0;
    }

    $form_class = 'media-upload-form type-form validate';

    ?>
    <div class="wrap">
        <form enctype="multipart/form-data" method="post" action="" class="<?php echo esc_attr( $form_class ); ?>" id="file-form">
            <?php dp_uploader(); ?>
            <script type="text/javascript">
            var post_id = <?php echo $post_id; ?>, shortform = 3;
            </script>
            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
            <div id="media-items" class="hide-if-no-js"></div>
        </form>
    </div>

</div>