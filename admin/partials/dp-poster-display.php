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
<div class="dp-container">
    <h2 class="devtey-title">Devtey Poster <span class="devtey-version">v1.0.0</span></h2> 
    <hr>
  <form>

    <label for="kategori" class="devtey-label-title">Pilih Kategori</label>
    <select id="kategori" name="kategori" class="devtey-form">
      <option value="australia">Australia</option>
      <option value="canada">Canada</option>
      <option value="usa">USA</option>
    </select>

    <label for="post-title" class="devtey-label-title">Format Judul</label>
    <input name="post-title" type="text" id="post-title" placeholder="Contoh: Wallpaper {file_name} Free Download" class="devtey-form">

    <div class="devtey-toggle">
        <label class="switch">
            <input type="checkbox">
            <span class="slider"></span>
        </label>
        <label class="desc">
            <span class="title devtey-label-title">Auto Tag</span>
            <span class="desc">(Membuat tag otomatis dari file name gambar.)</span>
        </label>
    </div>
    

    <div class="devtey-toggle">
        <label class="switch">
            <input type="checkbox">
            <span class="slider"></span>
        </label>
        <label class="desc">
            <span class="title devtey-label-title">Hapus Exif</span>
            <span class="desc">(Hapus exif data dari gambar wallpaper yang hendak diupload.)</span>
        </label>
    </div>

    <div class="devtey-toggle">
        <label class="switch">
            <input type="checkbox">
            <span class="slider"></span>
        </label>
        <label class="desc">
            <span class="title devtey-label-title">Capitalize Judul</span>
            <span class="desc">(Rapikan judul posting dengan Captizalize Judul.)</span>
        </label>
    </div>

    <div class="devtey-toggle">
        <label class="switch">
            <input type="checkbox">
            <span class="slider"></span>
        </label>
        <label class="desc">
            <span class="title devtey-label-title">Auto Deskripsi</span>
            <span class="desc">(Membuat deskripsi otomatis untuk posting, diambil dari tags.)</span>
        </label>
    </div>

    <div><input type="submit" value="Simpan" class="devtey-submit"></div>

  </form>
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