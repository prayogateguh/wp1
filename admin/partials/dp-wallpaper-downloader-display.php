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
    <h2 class="devtey-title">Wallpaper Downloader</h2>
    <?php if (get_option('dp-download-status') == 1) { ?>
    <div class="devtey-label-title">Download status: <span class="dp-scheduler-status dp-aktif" style="padding:2px;">on</span></div>
    <?php } else { ?>
    <div class="devtey-label-title">Download status: <span class="dp-scheduler-status dp-nonaktif" style="padding:2px;">off</span></div>
    <?php } ?>
    <hr>

    <form method="post" class="dp-form">
        <label for="post-title" class="devtey-label-title">Keywords</label>
        <textarea name="dp-keywords" id="dp-keywords" placeholder="Masukkan keywords perbaris" class="devtey-form" rows="4" cols="50"><?php echo esc_attr( $_POST['dp-keywords']); ?></textarea>
        <label for="dp-download-perkeyword" class="devtey-label-title">Limit wallpaper per keyword</label>
        <input name="dp-download-perkeyword" id="dp-download-perkeyword" placeholder="Masukkan berapa jumlah wallpaper yang ingin didownload per-keywordnya." class="devtey-form" value="<?php echo esc_attr( $_POST['dp-download-perkeyword']); ?>" />
        <p>Wallpaper akan tersimpan di <span style="font-weight: bold;"><?php echo wp_upload_dir()['basedir']; ?></span></p>
        <div class="submit">
            <input name="dp-downloader-status" type="submit" value="Download" class="button button-primary aktif">
        </div>
    </form>
</div>