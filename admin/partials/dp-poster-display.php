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
  <form method="post" action="options.php">
    <?php settings_fields( 'dp-poster-settings' ); ?>
    <?php do_settings_sections( 'dp-poster-settings' ); ?>
    <label for="kategori" class="devtey-label-title">Pilih Kategori</label>
    <select id="kategori" name="dp-kategori" class="devtey-form">
    <?php
        $args = array('hide_empty' => false);
        $categories = get_categories( $args );
        $stored_category_id = esc_attr( get_option('dp-kategori') );
        foreach ( $categories as $category ) { 
            $selected = ( $stored_category_id ==  $category->term_id  ) ? 'selected' : ''; ?>
            <option name="kategories[option_one]" value="<?php echo $category->term_id ?>" <?php echo $selected ?>><?php echo $category->name ?></option>
            <?php
        }
    ?>
    </select>

    <label for="post-title" class="devtey-label-title">Format Judul</label>
    <input name="dp-post-title" type="text" id="post-title" placeholder="Contoh: Wallpaper {file_name} Free Download" class="devtey-form" value="<?php echo esc_attr( get_option('dp-post-title') ); ?>">

    <div class="devtey-toggle">
        <label class="switch">
            <input type="checkbox" name="dp-multi-wallpapers" value="1" <?php checked( get_option('dp-multi-wallpapers') ); ?>>
            <span class="slider"></span>
        </label>
        <label class="desc">
            <span class="title devtey-label-title">Banyak Wallpaper dalam satu post?</span>
            <span class="desc">(Jika diaktifkan, satu posting akan berisikan banyak wallpaper/gallery.)</span>
        </label>
    </div>

    <div class="devtey-toggle">
        <label class="switch">
            <input type="checkbox" name="dp-auto-tag" value="1" <?php checked( get_option('dp-auto-tag') ); ?>>
            <span class="slider"></span>
        </label>
        <label class="desc">
            <span class="title devtey-label-title">Auto Tag</span>
            <span class="desc">(Membuat tag otomatis dari file name gambar.)</span>
        </label>
    </div>
    

    <div class="devtey-toggle">
        <label class="switch">
            <input type="checkbox" name="dp-hapus-exif" value="1" <?php checked( get_option('dp-hapus-exif') ); ?>>
            <span class="slider"></span>
        </label>
        <label class="desc">
            <span class="title devtey-label-title">Hapus Exif</span>
            <span class="desc">(Hapus exif data dari gambar wallpaper yang hendak diupload.)</span>
        </label>
    </div>

    <div class="devtey-toggle">
        <label class="switch">
            <input type="checkbox" name="dp-cap-judul" value="1" <?php checked( get_option('dp-cap-judul') ); ?>>
            <span class="slider"></span>
        </label>
        <label class="desc">
            <span class="title devtey-label-title">Capitalize Judul</span>
            <span class="desc">(Rapikan judul posting dengan Captizalize Judul.)</span>
        </label>
    </div>

    <div class="devtey-toggle">
        <label class="switch">
            <input id="dp-toggle-desc" type="checkbox" name="dp-auto-desc" onclick="show_desc()" value="1" <?php checked( get_option('dp-auto-desc') ); ?>>
            <span class="slider"></span>
        </label>
        <label class="desc">
            <span class="title devtey-label-title">Auto Deskripsi</span>
            <span class="desc">(Membuat deskripsi otomatis untuk posting, diambil dari tags.)</span>
        </label>
        <div id="desc-text" <?php if (get_option('dp-auto-desc') != 1) { ?>style="display:none;"<?php } ?>>
            <?php
                if (isset($_POST['dp-desc-text'])) {
                    update_option('dp-desc-text', stripslashes(wp_filter_post_kses(addslashes($_POST['dp-desc-text']))));
                }
            ?>
            <textarea id="dp-desc-text" name="dp-desc-text" cols="30" rows="10" ><?php echo esc_attr( get_option('dp-desc-text') ); ?></textarea>
            <input id="show-info" type="checkbox" onclick="show_desc()" value="info">Show Info
            <div id="desc-info" style="display:none;"><h4>Pilihan tag template: 
                <span class="desc-tag">
                    {{post_author}}, {{post_title}}, {{post_date}}, {{post_cats}}, {{post_tags}}, 
                    {{attch_img_name}}, {{attch_img_page}}, {{attch_img_loc}}, {{attch_img_res}}, {{attch_img_size}}, {{all_attch_img}}
                </span>
                </h4>
                <p style="font-style: italic;color: #666;">Silakan request jika membutuhkan tag yang lain.</p>
            </div>
            
        </div>
        <script>
            function show_desc() {
                // Get the checkbox
                var checkBox = document.getElementById("dp-toggle-desc");
                var show_info = document.getElementById("show-info");
                // Get the output text
                var text = document.getElementById("desc-text");
                var info_box = document.getElementById("desc-info");

                // If the checkbox is checked, display the output text
                if (checkBox.checked) {
                    text.style.display = "block";
                } else {
                    text.style.display = "none";
                }

                // info_box.style.display = "none";
                if (show_info.click) {
                    info_box.style.display = (info_box.dataset.toggled ^= 1) ? "block" : "none";
                }
            }
        </script>
    </div>

    <div>
        <input type="submit" value="Simpan" class="button button-primary aktif">
    </div>

  </form>
</div>
<?php
if ( isset( $_POST['dp-desc-text'])) {
    echo $_POST['dp-desc-text'];
}
?>
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

$title = __('Upload Wallpapers');

$form_class = 'media-upload-form type-form validate';

?>
<div class="wrap">
	<h1><?php echo esc_html( $title ); ?></h1>
    <form enctype="multipart/form-data" method="post" action="" class="<?php echo esc_attr( $form_class ); ?>" id="file-form">
        <?php dp_uploader(); ?>
        <script type="text/javascript">
        var post_id = <?php echo $post_id; ?>, shortform = 3;
        </script>
        <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
		<div id="media-items" class="hide-if-no-js"></div>
    </form>
</div>