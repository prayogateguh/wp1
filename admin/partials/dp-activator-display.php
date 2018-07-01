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
    <?php if (empty(get_option('dp_poster'))) { ?>
        <p>Silakan masukkan kode lisensi untuk mengaktifkan plugin ini. Lisensi telah diberikan ketika kamu membeli Devtey Poster.</p>
    <?php } else { ?>
        <p><span class="dp-aktif">Plugin Telah Aktif</span>, terima kasih telah membeli produk kami. Semoga bermanfaat. :)</p>
    <?php } ?>
    
    <form method="post">
        <label for="dp_key" class="devtey-label-title">Kode Lisensi</label>
        <input name="dp_key" type="text" id="dp_key" placeholder="XXXX-XXXX-XXXX" class="devtey-form" value="<?php echo esc_attr( get_option('dp_key') ); ?>">
        <div>
        <?php
            if (get_option('dp_poster') != 1) { ?>
            <input type="submit" name="dp_on" value="Hidupkan" class="button button-primary aktif" />
            <?php } ?>
        </div>
        <?php if (get_option('dp_poster') == 2) { ?>
            <small>Aktivasi error, silakan cek lisensi Anda.</small>
        <?php } ?>
    </form>
    
    
</div>