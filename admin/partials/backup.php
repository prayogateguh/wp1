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

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
<h2>Poster Configuration</h2>
    <div class="one-third unit">
		<form method="post" action="options.php" id="bip-upload-form">
            <?php 
            settings_fields( 'bip-upload-group' );
			do_settings_sections( 'bip-upload-group' );

            $selected_taxs = get_option('bip_taxonomy');
            if (!empty($selected_taxs)) {
                foreach ($selected_taxs as $selected_tax) {
                    $selected_cats = get_option('bip_terms');
                    $walker = new Walker_Bip_Terms( $selected_cats, $selected_tax ); ?>
                    <div class="postbox">
                        <div title="Click to toggle" class="handlediv"><br></div>
                        <div class="inside">
                            <div class="categorydiv">
                                <div class="tabs-panel">
                                    <div class="checkbox-container">
                                    <h4>Pilih Kategori</h4>
                                        <ul class="categorychecklist ">
                                            <?php 
                                            $args = array(
                                            'descendants_and_self'  => 0,
                                            'selected_cats'         => $selected_cats,
                                            'popular_cats'          => false,
                                            'walker'                => $walker,
                                            'taxonomy'              => $selected_tax,
                                            'checked_ontop'         => false ); ?>
                                            <?php wp_terms_checklist( 0, $args ); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php submit_button(); ?>
                        </div>
                    </div>
            <?php } } ?>
		</form>
		<div id="saveResult"></div>
    </div>
</div>

<?php
if (!current_user_can('upload_files'))
	wp_die(__('Sorry, you are not allowed to upload files.'));
		
wp_enqueue_script('plupload-handlers');
		
$post_id = 0;
if ( isset( $_REQUEST['post_id'] ) ) {
    $post_id = absint( $_REQUEST['post_id'] );
    if ( ! get_post( $post_id ) || ! current_user_can( 'edit_post', $post_id ) )
        $post_id = 0;
}

if ( $_POST ) {
    if ( isset($_POST['html-upload']) && !empty($_FILES) ) {
        check_admin_referer('media-form');
        // Upload File button was clicked
        $upload_id = media_handle_upload( 'async-upload', $post_id );
        if ( is_wp_error( $upload_id ) ) {
            wp_die( $upload_id );
        }
    }
    wp_redirect( admin_url( 'upload.php' ) );
    exit;
}

$title = __('Upload Wallpapers');

$form_class = 'media-upload-form type-form validate';

?>
<div class="wrap">
	<h1><?php echo esc_html( $title ); ?></h1>
    <form enctype="multipart/form-data" method="post" action="<?php echo admin_url('media-new.php'); ?>" class="<?php echo esc_attr( $form_class ); ?>" id="file-form">
        <?php media_upload_form(); ?>	
        <script type="text/javascript">
        var post_id = <?php echo $post_id; ?>, shortform = 3;
        </script>
		<input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
		<?php wp_nonce_field('media-form'); ?>
		<div id="media-items" class="hide-if-no-js"></div>
	</form>
</div>