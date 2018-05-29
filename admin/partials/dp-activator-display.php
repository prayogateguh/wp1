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
    <p>Silakan masukkan kode lisensi untuk mengaktifkan plugin ini. Lisensi telah diberikan ketika kamu membeli Devtey Poster.</p>
    <form action="">
        <label for="post-title" class="devtey-label-title">Kode Lisensi</label>
        <input name="post-title" type="text" id="post-title" placeholder="XXXX-XXXX-XXXX" class="devtey-form">

        <div>
        <?php if ( true ) { ?>
            <input type="hidden" name="dp-aktif" value="1">
            <?php submit_button( 'Aktifkan', 'primary aktif' ); ?>
        <?php } else { ?>
            <input type="hidden" name="dp-aktif" value="0">
            <?php submit_button( 'Non Aktifkan', 'non-aktif' ); ?>
        <?php } ?>
        </div>
    </form>
    <p><span class="dp-aktif">Plugin Telah Aktif</span>, terima kasih telah membeli produk kami. Semoga bermanfaat. :)</p>
    <p><span class="dp-nonaktif">Gagal aktivasi</span>, silakan dicek kembali kode lisensimu. Terima kasih.</p>
</div>